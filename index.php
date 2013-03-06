<?

class RecursiveDOMIterator implements RecursiveIterator
{
    /**
     * Current Position in DOMNodeList
     * @var Integer
     */
    protected $_position;

    /**
     * The DOMNodeList with all children to iterate over
     * @var DOMNodeList
     */
    protected $_nodeList;

    /**
     * @param DOMNode $domNode
     * @return void
     */
    public function __construct(DOMNode $domNode)
    {
        $this->_position = 0;
        $this->_nodeList = $domNode->childNodes;
    }

    /**
     * Returns the current DOMNode
     * @return DOMNode
     */
    public function current()
    {
        return $this->_nodeList->item($this->_position);
    }

    /**
     * Returns an iterator for the current iterator entry
     * @return RecursiveDOMIterator
     */
    public function getChildren()
    {
        return new self($this->current());
    }

    /**
     * Returns if an iterator can be created for the current entry.
     * @return Boolean
     */
    public function hasChildren()
    {
        return $this->current()->hasChildNodes();
    }

    /**
     * Returns the current position
     * @return Integer
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Moves the current position to the next element.
     * @return void
     */
    public function next()
    {
        $this->_position++;
    }

    /**
     * Rewind the Iterator to the first element
     * @return void
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * Checks if current position is valid
     * @return Boolean
     */
    public function valid()
    {
        return $this->_position < $this->_nodeList->length;
    }
}

//echo file_get_html('http://www.google.com/')->plaintext; 

$url = 'http://www.investing.com/currencies/eur-usd';
$url = 'www.investing.com/equities/apple-computer-inc?cid=23227';
//$html = file_get_contents($url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );  
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');   
$html = curl_exec($ch);
curl_close($ch);

//$html = file_get_html('index.php');


$dom = new DOMDocument();
$dom->loadHTML($html);

$dit = new RecursiveIteratorIterator(
            new RecursiveDOMIterator($dom),
            RecursiveIteratorIterator::SELF_FIRST);

foreach($dit as $node) {
    if($node->nodeType === XML_ELEMENT_NODE) {
    	    if($node->nodeName == 'html') continue; 
    	if($node->nodeName == 'body') continue;     
    	 if($node->nodeName == 'script') continue;
    	  if($node->nodeName == 'style') continue; 
    	  if($node->nodeName == 'div') continue; 
    	if($node->nodeName == 'textarea') continue; 
    	  
    	  
    	  echo   $node->nodeName."<br>";
    	  if($node->nodeName == 'link'){
    	  
    	  	echo $node->getAttribute('rel')."<br>";
    	  	echo $node->getAttribute('href')."<br>";
		
    	  }
    	  
    	  if($node->nodeName == 'meta'){
    	  
    	  	echo $node->getAttribute('name')."<br>";
    	  	echo $node->getAttribute('content')."<br>";
		
    	  }
    	  if($node->nodeName == 'a'){
    	  
    	  	echo $node->getAttribute('href')."<br>";
    	  	//echo $node->getAttribute('content');
		
    	  }
    	 
        
        echo   $node->nodeValue."<br><hr>";
    }
}


?>
