<?php
/**
 * ezcpoDemoAddress2
 *
 * @package Demo
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @Persistent(table=address2)
 * @OneToOne(class=ezcpoDemoPerson2,from=person_firstname+person_lastname,to=firstname+lastname)
 */
class ezcpoDemoAddress2
{
    /**
     * The address properties.
     *
     * @type array<mixed>
     * @var array $properties
     *
     * @Property(column=address_id,name=id,type=int,id=true)
     * @Generator(type=native)
     * @Property(column=person_firstname,name=personFirstname,type=string)
     * @Property(column=person_lastname,name=personLastname,type=string)
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
            "id"               =>  null,
            "personFirstname"  =>  "",
            "personLastname"   =>  "",
            "street"           =>  "",
            "zip"              =>  0,
            "city"             =>  "",
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
            "id"               =>  $this->id,
            "personFirstname"  =>  $this->personFirstname,
            "personLastname"   =>  $this->personLastname,
            "street"           =>  $this->street,
            "zip"              =>  $this->zip,
            "city"             =>  $this->city,
        );
    }

    /**
     * Object state setter method.
     *
     * @param array $state
     */
    public function setState( array $state )
    {
        $this->id              = $state["id"];
        $this->personFirstname = $state["personFirstname"];
        $this->personLastname  = $state["personLastname"];
        $this->street          = $state["street"];
        $this->zip             = $state["zip"];
        $this->city            = $state["city"];
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
            case "id":
            case "personFirstname":
            case "personLastname":
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