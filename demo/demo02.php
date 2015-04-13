<?php

// Import config
require_once "../config/config.php";

// Get persistent session
$session = ezcPersistentSessionInstance::get();

print "Inserting two new person records\n";
print "===================================================================\n\n";

$person1 = new ezcpoDemoPerson2();
$person1->firstname = "Manuel";
$person1->lastname  = "Pichler";
$person1->age       = 28;

$session->save( $person1 );


$person2 = new ezcpoDemoPerson2();
$person2->firstname = "Katrin";
$person2->lastname  = "Pichler";
$person2->age       = 27;

$session->save( $person2 );


print "Following persons are present now:\n\n";

print_r( $session->load( "ezcpoDemoPerson2", $person1->id ) );
print_r( $session->load( "ezcpoDemoPerson2", $person2->id ) );

print "Adding address for person '{$person1->firstname} {$person1->lastname}'\n";
print "===================================================================\n\n";

$address1 = new ezcpoDemoAddress2();
$address1->street = "Gustav-Knepper-Weg";
$address1->zip    = 58456;
$address1->city   = "Witten";
$address1->personFirstname = $person1->firstname;
$address1->personLastname  = $person1->lastname;

$session->save( $address1 );

print "The new address id is '{$address1->id}'\n\n";

print "Testing: \$session->getRelatedObjects( \$person1, 'ezcpoDemoAddress2' ):\n\n";

$addresses = $session->getRelatedObjects( $person1, "ezcpoDemoAddress2" );
foreach ( $addresses as $address )
{
    print_r( $address );
}

print "Testing cascade delete: \$session->delete( \$person ); \n\n";

$session->delete( $person1 );

print "Search for address id '{$address1->id}'\n\n";

try
{
    $session->load( "ezcpoDemoAddress2", $address1->id );
}
catch ( ezcPersistentQueryException $e )
{
    print "Not Found\n\n";
}

print "Clean up\n";
print "===================================================================\n\n";

$session->delete( $person2 );
