<?php
// Check sapi
if ( php_sapi_name() !== "cli" )
{
    header( "Content-Type: text/plain" );
}

// Import ezcBase class
require_once "ezc/Base/base.php";

// Register class repository
ezcBase::addClassRepository( 
    dirname( __FILE__ ) . "/../src/",
    dirname( __FILE__ ) . "/../src/autoload"
);

/**
 * Main autoload function. 
 */
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

// The demo database
$sqlitedb = dirname( __FILE__ ) . "/../data/ezcpo.db";

// Init database
ezcDbInstance::set( ezcDbFactory::create( "sqlite://{$sqlitedb}" ) );

// Init persistent object session
ezcPersistentSessionInstance::set(
    new ezcPersistentSession(
        ezcDbInstance::get(), new ezcpoPersistentCodeManager( dirname(__FILE__) . "/../defs", true )
    )
);