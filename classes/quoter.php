<?php
class Quoter
{
  function __construct()
  {
    $this->request = $_REQUEST;
    $this->user_id = null;
    $this->valid = false;
    $this->reserved = array("next");
    $this->max_per_text = 3;
  }
  
  function get_user()
  {
    $user = new User;
    $users = $user->GetList(array(array("phone","=",$this->request['From'])));
    if (count($users) == 0) {
      $user = new User;
      $user->phone = $this->request['From'];
      $user->location = $this->request['FromCity'] . ", " . $this->request['FromState'];
      $user->created_at = time();
      $this->user_id = $user->Save();
      $this->user = $user;
    } else {
      $this->user_id = $users[0]->userId;
      $this->user = $users[0];
    }
  }
  
  function is_valid_query()
  {
    if (isset($_REQUEST['Body'])) {
      $this->body = $_REQUEST['Body'];
      if (!in_array(trim(strtolower($_REQUEST['Body'])), $this->reserved)) {
        $this->valid = true;
      }
    }
      
    return !($_REQUEST['Body'] == '' || $_REQUEST['Body'] == NULL || !isset($_REQUEST['Body']));
  }
  
  function do_command()
  {
    return 'do command';
  }
  
  function do_query()
  {
    $this->body = stripslashes($this->body);
    $this->offset = 0;
    
    if (!$this->valid) {
      $this->body = $this->user->last_search;
      if ($this->user->last_offset != 0 || $this->user->last_ofset != null || $this->user->last_offset !== '')
        $this->offset = $this->user->last_offset;
    }
    
    $html = file_get_html('http://www.subzin.com/s/' . urlencode($this->body));
    
    /* set offset if they've done this search before */
    
    
    
    //$html = file_get_html('local.html');
    $response = "";
    
    /* has been found in how many? */
    foreach ($html->find('#wordstofind') as $el) {
      $matches = array();
      if (
        preg_match("/has been found in (.+) phrases from (.*) movies and series/", $el, $matches)
        < 1)
      {
        return "No quotes found for query: $this->body";
      }
      array_shift($matches);
      $this->offset_plus = $this->offset + $this->max_per_text;
      if ($this->offset_plus > intval($matches[0])) {
        $this->offset_plus = $matches[0];
      }
      $response = "$matches[0] phrases, $matches[1] movies & series ";
      if ($this->offset > 0) {
        $response = "'$this->body': ";
      }
      
      $response .= "[$this->offset-$this->offset_plus]\n";
      
      /* too many? */
      if ($this->offset > $matches[0]) {
        $response = "No more quotes for: '$this->body'.  Text something else to try that!";
        $this->user->last_offset = 0;
        $this->user->last_search = '';
        $this->user->Save();
        return $response;
      }
    }
    
    /* get items */
    $movies = array();
    $i = 0;
    $titles = $html->find("h1.title");
    array_shift($titles);
    $years = $html->find('p.title');
    $printed = false;
    foreach ($titles as $title) {
      if ($i >= $this->offset && $i < $this->offset + $this->max_per_text) {
        $response .= strip_tags("$title $years[$i]\n");
      } else if (!$printed) {
        $response .= "text NEXT to see more\n";
        $printed = true;
      }
      $i++; 
    }

    
    /* Save the user */
    $this->user->last_search = $this->body;
    $this->user->last_offset = $this->offset + $this->max_per_text;
    $this->user->Save();
    
    $this->response = $response;
  }
  
  function query_response()
  {
    $this->do_query();
    $this->byline = "--\nby.colinyoung.com";
    $this->response = htmlentities($this->response);
    
    if (strlen($this->response) + strlen($this->byline) < 160-strlen($this->byline)) {
      $this->response .= $this->byline;
    }
    $str = substr($this->response, 0, 159);
    return $str;
  }

}