<?php
// Doesn't work at the moment.
//return;

// Import config
require_once "../config/config.php";

// Get persistent session
$session = ezcPersistentSessionInstance::get();

$address = $session->load( "ezcpoDemoAddress4", 1 );

$address->getRelatedObjects( $address, "ezcpoDemoPerson4" );

$session->addRelatedObject( $address, $session->load( "ezcpoDemoPerson4", 1 ) );
