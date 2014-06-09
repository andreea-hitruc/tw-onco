<?php

/*
clasa xCard
se ocupa de prelucrarea fisierelor xCard
*/

class xCard {
	public $doc;
	private $file;
	function __construct($filePath){//initializare
		$this->file = $filePath;
		$this->doc = new DOMDocument();
		$this->doc->load($filePath);//incarcam xml-ul  cu xCard
	}
	
	function count(){//vedem cate contacte exista
		$xpath = new DOMXpath($this->doc);
		$cards = $xpath->query('/vcards/vcard');
		return $cards->length;
	}
	
	function get_cards(){//selectam toate contactele
		$xpath = new DOMXpath($this->doc);
		$cards = $xpath->query('/vcards/vcard');
		return $cards;
	}
	
	function query($query){//executam un  xpath query pe xml-ul xCard 
		$xpath = new DOMXpath($this->doc);
		return $xpath->query($query);
	}
	
	function export_csv(){//exportam in format csv
		$xpath = new DOMXpath($this->doc);
		//$rootNamespace = $this->doc->lookupNamespaceUri($this->doc->namespaceURI); 
		//$xpath->registerNamespace('urn:ietf:params:xml:ns:vcard-4.0', $rootNamespace);
		$cards = $xpath->query('/vcards/vcard');//selectam contactele
		$header = array('name', 'bday', 'gender', 'tel','email', 'address');//stabilim headerul fisierului
		$fName = microtime(true).'.csv';//alocam un nume unic fisierului
		$fp = fopen('temp/'.$fName,'w');//cream fisierul
		fputcsv($fp, $header);//scriem headerul fisierului
		
		foreach($cards as $card){
			$row = array();
			$row[] = $card->getElementsByTagName('fn')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;
			$row[] = $card->getElementsByTagName('bday')->item(0)->getElementsByTagName('date')->item(0)->nodeValue;
			$row[] = $card->getElementsByTagName('gender')->item(0)->getElementsByTagName('sex')->item(0)->nodeValue;
			$row[] = $card->getElementsByTagName('tel')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue;
			$row[] = $card->getElementsByTagName('email')->item(0)->getElementsByTagName('text')->item(1)->nodeValue;
			$row[] = $card->getElementsByTagName('adr')->item(0)->getElementsByTagName('parameters')->item(0)->getElementsByTagName('label')->item(0)->getElementsByTagName('text')->item(0)->nodeValue;
			
			fputcsv($fp,$row);//scriem  contactul in fisier
		}
		fclose($fp);
		return $fName;
	}
	
	function export_vcard(){
		$xpath = new DOMXpath($this->doc);
		$cards = $xpath->query('/vcards/vcard');
		$i = 0;
		$zipName = microtime(true).'.zip';//alocam un nume
		$zip = new ZipArchive();
		if ($zip->open('temp/'.$zipName,ZipArchive::CREATE) !== TRUE) {//cream o arhiva zip
			return false;
		} 
		$delete = array();
		
		foreach($cards as $card){//formatam contactele in format vCard
			$content = "BEGIN:VCARD\nVERSION:2.1\n";
			$content .= "N;LANGUAGE=en-us;CHARSET=utf-8:";
			$content .= $card->getElementsByTagName('n')->item(0)->getElementsByTagName('surname')->item(0)->nodeValue.';';
			$content .= $card->getElementsByTagName('n')->item(0)->getElementsByTagName('given')->item(0)->nodeValue.';';
			$content .= $card->getElementsByTagName('n')->item(0)->getElementsByTagName('prefix')->item(0)->nodeValue.';';
			$content .= $card->getElementsByTagName('n')->item(0)->getElementsByTagName('suffix')->item(0)->nodeValue."\n";
			
			$content .= "FN;CHARSET=utf-8:";
			$content .= $card->getElementsByTagName('n')->item(0)->getElementsByTagName('prefix')->item(0)->nodeValue.' '.
								$card->getElementsByTagName('n')->item(0)->getElementsByTagName('surname')->item(0)->nodeValue.' '.
								$card->getElementsByTagName('n')->item(0)->getElementsByTagName('given')->item(0)->nodeValue.' '.
								$card->getElementsByTagName('n')->item(0)->getElementsByTagName('suffix')->item(0)->nodeValue."\n";
								
			$content .= "TEL;WORK:";
			$content .= $card->getElementsByTagName('tel')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue."\n";
								
			$content .= "EMAIL;PREF;INTERNET:";
			$content .= $card->getElementsByTagName('email')->item(0)->getElementsByTagName('text')->item(1)->nodeValue."\n";
			
			$fotoPath = !empty($card->getElementsByTagName('photo')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue)?$card->getElementsByTagName('photo')->item(0)->getElementsByTagName('uri')->item(0)->nodeValue:'';
			if(!empty($fotoPath)){
				$path_parts = pathinfo($fotoPath);
				$type = 'JPEG';
				switch(strtolower ($path_parts['extension'])){
					case 'jpg': ;
					case 'jpeg' : $type = 'JPEG'; break;
					case 'png' : $type = 'PNG'; break;
					case 'gif' : $type = 'GIF'; break;
					default : $type = 'JPEG';
				}
				
				
				$content .= "PHOTO;TYPE=".$type.";ENCODING=BASE64:\n";
				$content .= base64_encode(file_get_contents($fotoPath))."\n\n";
			}
			$content .= 'END:VCARD'."\n\n";
			$fName = $i.'_'.$card->getElementsByTagName('fn')->item(0)->getElementsByTagName('text')->item(0)->nodeValue.'.vcf';
			$fp = fopen('temp/vcard/'.$fName,'w');//scriem contactul in folderul temporar
			fwrite($fp,$content);
			fclose($fp);
			$zip->addFile('temp/vcard/'.$fName,$fName);//adaugam contactele in arhiva
			$delete[]  = $fName;
			$i++;
		}
		
		$zip->close();//inchedem arhiva
		
		foreach($delete as $file){
			@unlink($file);//stergem fisierele temporare
		}
		
		
		return $zipName;		
	}
	
	
	function add($node){//adaugam un contact nou
		$node = $this->doc->importNode($node, true);
		$this->doc->documentElement->appendChild($node);
		$this->doc->save($this->file);
	}
	
	function save(){
		$this->doc->save($this->file);
	}	
	
	
}
?>