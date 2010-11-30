<?php
header("Content-Type: application/xml");
print '<?xml version="1.0" encoding="UTF-8" ?>';
include('init.php');
$Quoter = new Quoter();
$Quoter->get_user();
if ($Quoter->is_valid_query()):
?>
<Response>
  <Sms><?php print $Quoter->query_response(); ?></Sms>
</Response>
<?php else: ?>
<Response>
  <Sms>Sorry, we couldn't understand your search.</Sms>
</Response>
<?php endif; ?>