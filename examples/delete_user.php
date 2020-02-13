<?php

use Detain\MyAdminDirectAdminWeb\HTTPSocket;

require_once('../vendor/autoload.php');

$server_login="admin";
$server_pass="admin_password";
$server_host="da1.is.cc"; //where the API connects to
$server_ssl="Y";
$server_port=2222;

$username='firstsit';

$sock = new HTTPSocket;
if ($server_ssl == 'Y')
{
	$sock->connect("ssl://".$server_host, $server_port);
}
else
{ 
	$sock->connect($server_host, $server_port);
}

$sock->set_login($server_login,$server_pass);

echo "Creating user $username on $server_host.... <br>\n";

$sock->query('/CMD_API_SELECT_USERS',
	array(
		'confirmed' => 'Confirm',
		'delete' => 'yes',
		'select0' => $username,
	));

$result = $sock->fetch_parsed_body();
print_r($result);

if ($result['error'] != "0")
{
	echo "<b>Error Deleting user $username :<br>\n";
	echo $result['text']."<br>\n";
	echo $result['details']."<br></b>\n";
}
else
{
	echo "User $username created<br>\n";
}

exit(0);
