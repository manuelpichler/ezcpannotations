<?php

// Import config
require_once "../config/config.php";

// Get persistent session
$session = ezcPersistentSessionInstance::get();

print "Inserting two new person records\n";
print "===================================================================\n\n";

$person1 = new ezcpoDemoPerson1();
$person1->name = "Manuel Pichler";
$person1->age  = 28;

$session->save( $person1 );


$person2 = new ezcpoDemoPerson1();
$person2->name = "Katrin Pichler";
$person2->age  = 27;

$session->save( $person2 );


print "Following persons are present now:\n\n";

print_r( $session->load( "ezcpoDemoPerson1", $person1->id ) );
print_r( $session->load( "ezcpoDemoPerson1", $person2->id ) );

print "Adding address for person '{$person1->name}'\n";
print "===================================================================\n\n";

$address1 = new ezcpoDemoAddress1();
$address1->street = "Gustav-Knepper-Weg";
$address1->zip    = 58456;
$address1->city   = "Witten";
$address1->person = $person1->id;

$session->save( $address1 );

print "The new address id is '{$address1->id}'\n\n";

print "Testing: \$session->getRelatedObjects( \$person1, 'ezcpoDemoAddress1' ):\n\n";

$addresses = $session->getRelatedObjects( $person1, "ezcpoDemoAddress1" );
foreach ( $addresses as $address )
{
    print_r( $address );
}

print "Testing cascade delete: \$session->delete( \$person ); \n\n";

$session->delete( $person1 );

print "Search for address id '{$address1->id}'\n\n";

try 
{
    $session->load( "ezcpoDemoAddress1", $address1->id );
} 
catch ( ezcPersistentQueryException $e )
{
    print "Not Found\n\n";
}

print "Clean up\n";
print "===================================================================\n\n";

$session->delete( $person2 );
