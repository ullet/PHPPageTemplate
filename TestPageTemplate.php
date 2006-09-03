<?php
include_once("TestPageTemplate_code.php");
class TestPageTemplate extends TestPageTemplateCode
{    
    function RenderContent()
    { 
?>
<html>
  <head>
    <title><?= $this->get_EncodedTitle() ?></title>
  </head>
  <body>
    <h1><?= $this->get_EncodedHeading() ?></h1>
    <h2>Place Holder 1</h2>
    <?php $this->_RenderPlaceHolder("ph1") ?>
    <h2>Place Holder 2</h2>
    <?php $this->_RenderPlaceHolder("ph2") ?>
  </body>
</html>
<?php
    }        
}