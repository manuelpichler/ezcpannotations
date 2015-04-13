<?php

// Import config
require_once "../config/config.php";

// Get persistent session
$session = ezcPersistentSessionInstance::get();

print "Inserting two new person records\n";
print "===================================================================\n\n";

$person1 = new ezcpoDemoPerson3();
$person1->name = "Manuel Pichler";
$person1->age  = 28;

$session->save( $person1 );


$person2 = new ezcpoDemoPerson3();
$person2->name = "Katrin Pichler";
$person2->age  = 27;

$session->save( $person2 );


print "Following persons are present now:\n\n";

print_r( $session->load( "ezcpoDemoPerson3", $person1->id ) );
print_r( $session->load( "ezcpoDemoPerson3", $person2->id ) );

print "Adding new address\n";
print "===================================================================\n\n";

$address1 = new ezcpoDemoAddress3();
$address1->street = "Gustav-Knepper-Weg";
$address1->zip    = 58456;
$address1->city   = "Witten";

$session->save( $address1 );

print "The new address id is '{$address1->id}'\n\n";

print "Set as related object for '{$person1->name}' and '{$person2->name}'\n\n";

$session->addRelatedObject( $person1, $address1 );
$session->addRelatedObject( $person2, $address1 );

print "Testing: \$session->getRelatedObjects( \$person1, 'ezcpoDemoAddress3' ):\n\n";

$addresses = $session->getRelatedObjects( $person1, "ezcpoDemoAddress3" );
foreach ( $addresses as $address )
{
    print_r( $address );
}

print "Testing: \$session->getRelatedObjects( \$person2, 'ezcpoDemoAddress3' ):\n\n";

$addresses = $session->getRelatedObjects( $person2, "ezcpoDemoAddress3" );
foreach ( $addresses as $address )
{
    print_r( $address );
}



print "Clean up\n";
print "===================================================================\n\n";

$session->delete( $person2 );
