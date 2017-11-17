<?php

defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function faqInstall() {

}

## Hooks
## Code relatif au plugin

class faq
{
    /**
     * liste de question/réponse
     * @var faqItem[]
     */
    private $items;

    /**
     * fichier contenant la liste de question/réponse
     * @var string
     */
    private $faqFile;

    public function __construct()
    {
        $this->faqFile = DATA_PLUGIN . 'faq/faq.json';
        $this->items = $this->loadFaq();
    }

    /**
     * Charge la liste des question/réponse
     * @return faqItem[] liste de question/réponse
     */
    private function loadFaq()
    {
        $data = array();
		if (file_exists($this->faqFile)) {
			$faqData = util::readJsonFile($this->faqFile);
            foreach($faqData as $faqDataId => $faqItemData) {
				$data[intval($faqDataId)] = new faqItem($faqItemData);
			}
		}
		return $data;
	}

    /**
     * Rafraichi la liste des question/réponse
     */
    private function refreshFaq()
    {
        $this->items = $this->loadFaq();
        return $this->items;
    }

    /**
     * Rafraichi les positions des questions
     */
    private function refreshPos($faqData)
    {
        $data = array();
        $i = 0;
        foreach ($faqData as $faqItemId => $faqItemData) {
            $faqItemData['position'] = $i;
            $data[$faqItemId] = $faqItemData;
            $i++;
        }
        return $data;
    }

    /**
     * Retourne la liste des question/réponse
     * @return mixed[]
     */
    public function getItems()
    {
		return $this->items;
	}

    /**
     * Retourne la question/réponse dont l'id est donnée
     * @param int $id
     * @return faqItem|false
     */
    public function get($id)
    {
		if (isset($this->items[$id])) {
            return $this->items[$id];
        } else {
            return false;
        }
	}

    /**
     * Sauvegarde la faq avec une nouvelle question
     * @param faqItem $faqItem
     * @return boolean
     */
    public function save($faqItem)
    {
		if (1 > $id = intval($faqItem->getId())) {
            $id = $this->makeId();
        }
        $position = intval($faqItem->getPosition());

		$faqItemData = array(
			'id'        => $id,
            'position'  => $position,
			'question'  => $faqItem->getQuestion(),
            'answer'    => $faqItem->getAnswer(),
            'hidden'    => $faqItem->ishidden()
		);

        //var_dump($faqItemData);

        $tmpData = array();
        $faqData = util::readJsonFile($this->faqFile, true);
        if (isset($faqData[$id])) {
            unset($faqData[$id]);
            $faqData = $this->refreshPos($faqData);
        }
        
        //var_dump($faqData); exit;

        $keys = array_keys($faqData);
        if ($position !== $current_pos = array_search($id, $keys)) {
            // si la position est différente ou que l'item n'existe pas
            if ($current_pos !== false) {
                // l'item existe
                unset($faqData[$id]);
            }
            for ($i = 0; $i < $position; $i++) {
                $tmpData[$keys[$i]] = $faqData[$keys[$i]];
            }
            $tmpData[$id] = $faqItemData;
            for ($j = $i; $j < count($faqData); $j++) {
                $data = $faqData[$keys[$j]];
                $data['position'] = $j+1;
                $tmpData[$keys[$j]] = $data;
            }
            if(util::writeJsonFile($this->faqFile, $tmpData)) {
                $this->refreshFaq();
                return true;
            }
        }
		return false;
	}

    private function makeId()
    {
		if (count($this->items) > 0) {
            return max(array_keys($this->items))+1;
        } else {
            return 1;
        }
	}
}

class faqItem
{
    private $id;
    private $position;
    private $question;
    private $answer;
    private $hidden;

    public function __construct($val = array())
    {
		if (count($val) > 0) {
			$this->id = intval($val['id']);
			$this->position = intval($val['position']);
			$this->question = $val['question'];
			$this->answer = $val['answer'];
			$this->hidden = intval($val['hidden']) >= 1 ? 1 : 0;
		} else {
            $this->hidden = 0;
        }
	}

    /**
     * Retourne l'id de la question/reponse
     */
    public function getId() {
		return $this->id;
	}
	/**
     * Retourne la position de la question/reponse
     */
	public function getPosition() {
		return $this->position;
	}
	/**
     * Retourne la question
     */
	public function getQuestion() {
		return $this->question;
	}
	/**
     * Retourne la réponse
     */
	public function getAnswer() {
		return $this->answer;
	}
	/**
     * Retourne 1 si la question est cachée
     */
	public function isHidden() {
		return $this->hidden;
	}

    /**
     * @param int $id
     */
    public function setId($id) {
		$this->id = $id;
	}
	/**
     * @param int $position
     */
	public function setPosition($position) {
		$this->position = intval($position);
	}
	/**
     * @param string $question
     */
	public function setQuestion($question) {
		$this->question = trim($question);
	}
	/**
     * @param string $answer
     */
	public function setAnswer($answer) {
		$this->answer = trim($answer);
	}
	/**
     * @param int $hidden
     */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}
}

?>