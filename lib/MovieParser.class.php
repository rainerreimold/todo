<?php
class MovieParser {
	
	private $debug = false;

	private $stack = array();

	private $currentCategoryId = "";
	private $categories = array();

	private $currentFilmMap = NULL;
	private $filme = array();

	private function push($name) {
		array_push($this->stack, $name);
	}

	private function pop() {
		return array_pop($this->stack);
	}

	private function isOpen($tag) {
		return in_array($tag, $this->stack);
	}

	private function printPath() {
		if ($this->debug) {
			foreach ($this->stack as $name) {
				echo "/$name";
			}
			echo "<br/>";
		}
	}

	private function startElement($parser, $name, $attrs) {
		if ($name == "CATEGORY") {
			$this->currentCategoryId = $attrs['ID'];
		} elseif ($name == "MOVIE") {
			$cId = $attrs['CATEGORY'];
			$this->currentFilmMap = array('category'=>$this->categories[$cId]);
		}
		$this->push($name);
		$this->printPath();
	}

	private function endElement($parser, $name) {
		if ($name == "CATEGORY") {
			$this->currentCategoryId = "";
		} elseif ($name == "MOVIE") {
			if (empty($this->currentFilmMap['name'])) {
				throw new MovieParseException("Name von Movie nicht definiert!");
			}
			$film = new Film($this->currentFilmMap['name']);
			$film->setKategorie($this->currentFilmMap['category']);
			$schauspieler = $this->currentFilmMap['cast_firstname']." ".$this->currentFilmMap['cast_name'];
			$film->addSchauspieler($schauspieler);
			$this->filme[] = $film;
			$this->currentFilmMap = NULL;
		}
		$this->pop();
		$this->printPath();
	}

	private function charData($parser, $str) {
		if (!empty($this->currentCategoryId)) {
			$this->categories[$this->currentCategoryId] = $str;
		}
		if ($this->isOpen("CREW")) {
			// Do nothing!
		} elseif ($this->isOpen("CAST") && $this->isOpen("NAME")) {
			$this->currentFilmMap['cast_name'] = $str;
		} elseif ($this->isOpen("CAST") && $this->isOpen("FIRSTNAME")) {
			$this->currentFilmMap['cast_firstname'] = $str;
		} elseif ($this->isOpen("MOVIE") && $this->isOpen("NAME")) {
			$this->currentFilmMap['name'] = $str;
		}
	}

	public function parse($file) {
		$data = file_get_contents($file);
		try {
			$parser = xml_parser_create();
			xml_set_object($parser, $this);
			xml_set_element_handler($parser, "startElement", "endElement");
			xml_set_character_data_handler($parser, "charData");
			xml_parse($parser, $data);
			xml_parser_free($parser);
		} catch (MovieParseException $e) {
			echo "Versuche MovieParseException zu behandeln...";
			throw $e;
		}
	}
	
	public function getKategorien() {
		return $this->categories;
	}

	public function getFilme() {
		return $this->filme;
	}

	public function outputFilme() {
		echo "<ul>";
		foreach ($this->filme as $film) {
			echo "<li>";
			echo "<b>".$film->getName()."</b></br>";
			echo $film->getKategorie()."</br>";
			foreach ($film->getSchauspieler() as $s) {
				echo "$s, ";
			}
			echo "</li>";
		}
		echo "</ul>";
	}

}
