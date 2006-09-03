<?php
include_once("index_code.php");

class IndexPage extends IndexPageCode
{
    function PlaceHolder_ph1() 
    {
        $this->_DoPlaceHolderTest();
    }

    function PlaceHolder_ph2()
    { 
?>
  <p>
    This is the content to go in Place Holder 2.
    <br />
    Here is a list of stuff:
    <ul>
      <li>Rabbit</li>
      <li>Aeroplane</li>
      <li>Windows XP</li>
      <li>Madriva Linux</li>
      <li>Anti-static Cleaning Solution</li>
    </ul>
  </p>
<?php 
    }
}

$page =& new IndexPage();
$page->Render();
?>