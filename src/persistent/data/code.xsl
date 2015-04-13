<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="text" encoding="UTF-8" />
  
  <xsl:variable name="nl">
    <xsl:text>
</xsl:text>
  </xsl:variable>

  <xsl:template match="/">
    <xsl:text>&lt;?php</xsl:text>
    <xsl:value-of select="$nl" />
    <xsl:apply-templates select="*" />   
    <xsl:text>return $def;</xsl:text>
    <xsl:value-of select="$nl" />
    <xsl:text>?&gt;</xsl:text>
  </xsl:template>
  
  <xsl:template match="object">
    <!-- Create base class -->
    <xsl:text>$def = new ezcPersistentObjectDefinition();</xsl:text>
    <xsl:value-of select="$nl" />
    
    <!-- Setup database table -->
    <xsl:text>$def-&gt;table = "</xsl:text>
    <xsl:value-of select="@tableName" />
    <xsl:text>";</xsl:text>
    <xsl:value-of select="$nl" />
    
    <!-- Setup application class -->
    <xsl:text>$def-&gt;class = "</xsl:text>
    <xsl:value-of select="@className" />
    <xsl:text>";</xsl:text>
    <xsl:value-of select="$nl" />
    <xsl:value-of select="$nl" />
  </xsl:template>
  
  <xsl:template match="properties">
    <xsl:for-each select="*">
      <xsl:apply-templates select="." />
    </xsl:for-each>
  </xsl:template>
  
  <xsl:template match="property">
    <xsl:choose>
      <xsl:when test="@propertyIsId = 'true'">
        <xsl:text>$def-&gt;idProperty = new ezcPersistentObjectIdProperty();</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:text>$def-&gt;idProperty-&gt;columnName = "</xsl:text>
        <xsl:value-of select="@columnName" />
        <xsl:text>";</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:text>$def-&gt;idProperty-&gt;propertyName = "</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>";</xsl:text>
        <xsl:if test="count( ./generator ) = 0">
          <xsl:call-template name="id-generator" />
        </xsl:if>
        <xsl:if test="count( ./generator ) > 0">
          <xsl:call-template name="id-generator">
            <xsl:with-param name="generatorType" select="generator/@generatorType" />
            <xsl:with-param name="generatorParam" select="generator/@generatorParam" />
          </xsl:call-template>
        </xsl:if>
      </xsl:when>
      <xsl:otherwise>
        <xsl:text>$def-&gt;properties["</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>"] = new ezcPersistentObjectProperty();</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:text>$def-&gt;properties["</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>"]->columnName = "</xsl:text>
        <xsl:value-of select="@columnName" />
        <xsl:text>";</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:text>$def-&gt;properties["</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>"]->propertyName = "</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>";</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:text>$def-&gt;properties["</xsl:text>
        <xsl:value-of select="@propertyName" />
        <xsl:text>"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_</xsl:text>
        <xsl:value-of select="translate( @propertyType, 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' )" />
        <xsl:text>;</xsl:text>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:value-of select="$nl" />
    <xsl:value-of select="$nl" />
  </xsl:template>
  
  <xsl:template name="id-generator">
    <xsl:param name="generatorType" select="'manual'" />
    <xsl:param name="generatorParam" select="''" />
  
    <xsl:value-of select="$nl" />
    <xsl:text>$def-&gt;idProperty-&gt;generator = new ezcPersistentGeneratorDefinition(</xsl:text>
    <xsl:value-of select="$nl" />
    <xsl:text>    "ezcPersistent</xsl:text>
    <xsl:value-of select="translate( substring( $generatorType, 1, 1 ), 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' )" />
    <xsl:value-of select="translate( substring( $generatorType, 2 ),    'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz' )" />
    <xsl:text>Generator"</xsl:text>
    <xsl:if test="$generatorParam != ''">
      <xsl:text>,</xsl:text>
      <xsl:value-of select="$nl" />
      <xsl:text>    array( "sequence"  =>  "</xsl:text>
      <xsl:value-of select="$generatorParam" />
      <xsl:text>" )</xsl:text>
    </xsl:if>
    <xsl:value-of select="$nl" />
    <xsl:text>);</xsl:text>
  </xsl:template>
  
  <xsl:template match="relations">
    <xsl:apply-templates select="*" />
    <xsl:value-of select="$nl" />
  </xsl:template>
  
  <xsl:template match="relation[@tableName != '']">
    <xsl:call-template name="relation-two-tables"  />
    <xsl:call-template name="relation-mapping" />
  </xsl:template>
  
  <xsl:template name="relation-two-tables">
    <xsl:call-template name="relation-definition" />
    <xsl:text> = new ezcPersistent</xsl:text>
    <xsl:choose>
      <xsl:when test="@relationType = 'one-to-many'">
        <xsl:text>OneToMany</xsl:text>
      </xsl:when>
      <xsl:when test="@relationType = 'one-to-one'">
        <xsl:text>OneToOne</xsl:text>
      </xsl:when>
      <xsl:when test="@relationType = 'many-to-many'">
        <xsl:text>ManyToMany</xsl:text>
      </xsl:when>
    </xsl:choose>
    <xsl:text>Relation( "</xsl:text>
    <xsl:value-of select="//object/@tableName" />
    <xsl:text>", "</xsl:text>
    <xsl:value-of select="@tableName" />
    
    <!-- 
    {{{ Additional mapping table? 
    -->
    <xsl:if test="@relationTableName != ''">
      <xsl:text>", "</xsl:text>
      <xsl:value-of select="@relationTableName" />
    </xsl:if>
    <!-- 
    }}} 
    -->
    <xsl:text>" );</xsl:text>
    
    <xsl:value-of select="$nl" />  
  </xsl:template>
  
  <xsl:template name="relation-definition">
    <xsl:text>$def->relations["</xsl:text>
    <xsl:value-of select="@className" />
    <xsl:text>"]</xsl:text>
  </xsl:template>
  
  <xsl:template name="relation-mapping">
    <xsl:call-template name="relation-definition" />
    <xsl:text>-&gt;columnMap = array(</xsl:text>    
    <xsl:value-of select="$nl" />
    <xsl:choose>
      <xsl:when test="@across != ''">
        <xsl:call-template name="relation-double-table">
          <xsl:with-param name="from" select="@from" />
          <xsl:with-param name="to" select="@to" />
          <xsl:with-param name="across" select="@across" />
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <xsl:call-template name="relation-single-table">
          <xsl:with-param name="from" select="@from" />
          <xsl:with-param name="to" select="@to" />
        </xsl:call-template>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:value-of select="$nl" />
    <xsl:text>);</xsl:text>
    <xsl:value-of select="$nl" />
    
    <xsl:if test="@cascade = 'true'">
      <xsl:call-template name="relation-definition" />
      <xsl:text>-&gt;cascade = true;</xsl:text>
      <xsl:value-of select="$nl" />
    </xsl:if>
  </xsl:template>
  
  <xsl:template name="relation-single-table">
    <xsl:param name="from" />
    <xsl:param name="to" />
    
    <xsl:text>    new ezcPersistentSingleTableMap( "</xsl:text>
    <xsl:choose>
      <xsl:when test="contains( $from, '+' ) and contains( $to, '+' )">
    	<xsl:value-of select="substring-before( $from, '+' )" />
	    <xsl:text>", "</xsl:text>
    	<xsl:value-of select="substring-before( $to, '+' )" />
	  </xsl:when>
	  <xsl:otherwise>
    	<xsl:value-of select="$from" />
	    <xsl:text>", "</xsl:text>
    	<xsl:value-of select="$to" />	  
	  </xsl:otherwise>
    </xsl:choose>
    <xsl:text>" )</xsl:text>
    
    <!-- 
      Recursive recall of this template 
    -->
    <xsl:if test="contains( $from, '+' ) and contains( $to, '+' )">
      <xsl:text>, </xsl:text>
      <xsl:value-of select="$nl" />
      <xsl:call-template name="relation-single-table">
        <xsl:with-param name="from" select="substring-after( $from, '+')" />
        <xsl:with-param name="to" select="substring-after( $to, '+')" />
      </xsl:call-template>
    </xsl:if>
    
  </xsl:template>
  
  <xsl:template name="relation-double-table">
    <xsl:param name="from" />
    <xsl:param name="to" />
    <xsl:param name="across" />
    
    <!-- 
    Split across columns
    -->
    <xsl:variable name="left"  select="substring-before( $across, ';' )" />
    <xsl:variable name="right" select="substring-after( $across, ';' )" />
    
    <xsl:text>    new ezcPersistentDoubleTableMap( "</xsl:text>
    <xsl:choose>
	  <xsl:when test="contains( $from, '+' ) and contains( $left, '+' )">
	    <xsl:value-of select="substring-before( $from, '+' )" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="substring-before( $left, '+' )" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="$right" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="$to" />
	  </xsl:when>
	  <xsl:when test="contains( $to, '+' ) and contains( $right, '+' )">
	    <xsl:value-of select="$from" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="$left" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="substring-before( $right, '+' )" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="substring-before( $to, '+' )" />
	  </xsl:when>
	  <xsl:otherwise>
    	<xsl:value-of select="$from" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="$left" />
	    <xsl:text>", "</xsl:text>
	    <xsl:value-of select="$right" />
	    <xsl:text>", "</xsl:text>
    	<xsl:value-of select="$to" />	  
	  </xsl:otherwise>
    </xsl:choose>
    <xsl:text>" )</xsl:text>
    
    <!-- 
      Recursive recall of this template 
    -->
    <xsl:choose>
      <xsl:when test="contains( $from, '+' ) and contains( $left, '+' )">
        <xsl:text>,</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:call-template name="relation-double-table">
          <xsl:with-param name="from" select="substring-after( $from, '+' )" />
          <xsl:with-param name="across" select="concat( substring-after( $left, '+' ), concat( ';', $right ) )" />
          <xsl:with-param name="to" select="$to" />
        </xsl:call-template>
      </xsl:when>
      <xsl:when test="contains( $to, '+' ) and contains( $right, '+' )">
        <xsl:text>,</xsl:text>
        <xsl:value-of select="$nl" />
        <xsl:call-template name="relation-double-table">
          <xsl:with-param name="from" select="$from" />
          <xsl:with-param name="across" select="concat( $left, concat( ';', substring-after( $right, '+' ) ) )" />
          <xsl:with-param name="to" select="substring-after( $to, '+' )" />
        </xsl:call-template>
      </xsl:when>
    </xsl:choose>
  </xsl:template>
  
</xsl:stylesheet>