<?php
/**
 * ezcpoDemoAddress4
 *
 * @package Demo
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @Persistent(table=address4)
 * @ManyToMany(class=ezcpoDemoPerson4,table=person4_address4,columns=address_fid;person_firstname+person_lastname)
 */
class ezcpoDemoAddress4
{
    /**
     * The id for the address.
     * 
     * @type integer
     * @var integer $id
     * 
     * @Property(column=address_id,type=int,id=true)
     * @Generator(type=native)
     */
    protected $id;
    
    /**
     * The address properties.
     * 
     * @type array<mixed>
     * @var array $properties
     * 
     * @Property(column=street,name=street,type=string)
     * @Property(column=zip,name=zip,type=int)
     * @Property(column=city,name=city,type=string)
     */
    protected $properties = array();
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->properties = array(
            "street"  =>  "",
            "zip"     =>  0,
            "city"    =>  "",
        );
    }
    
    /**
     * Object state getter method.
     * 
     * @return array
     */
    public function getState()
    {
        return array(
            "id"      =>  $this->id,
            "street"  =>  $this->street,
            "zip"     =>  $this->zip,
            "city"    =>  $this->city,
        );
    }
    
    /**
     * Object state setter method.
     *
     * @param array $state
     */
    public function setState( array $state )
    {
        $this->id     = $state["id"];
        $this->street = $state["street"];
        $this->zip    = $state["zip"];
        $this->city   = $state["city"]; 
    }
    
    /**
     * Generic property getter.
     * 
     * @param string $name
     * @return mixed The property value.
     * 
     * @throws ezcBasePropertyNotFoundException
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case "id":
                return $this->id;
                
            default:
                if ( array_key_exists( $name, $this->properties ) )
                {
                    return $this->properties[$name];
                }
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
    
    /**
     * Generic property setter.
     * 
     * @param string $name
     * @param mixed $value
     * 
     * @throws ezcBasePropertyPermissionException
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case "street":
            case "zip":
            case "city":
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
        }
    }
}