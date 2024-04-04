<?php

include "../../vendor/autoload.php";

use AP\Structure\Collection\ObjectsCollection;

class Element {
    public function __construct(
        public int    $id,
        public string $label
    )
    {
    }
}

class ElementsCollection extends ObjectsCollection
{
    public function __construct()
    {
        parent::__construct(Element::class);
    }

    /**
     * @return Element[]
     */
    public function all(): array
    {
        return parent::all();
    }
}

$collection = new ElementsCollection();

$collection[] = new Element(id: 1, label: "orange");
$collection[] = new Element(id: 2, label: "banana");
$collection[] = new Element(id: 3, label: "apple");

foreach ($collection->all() as $element){
    echo "$element->id: $element->label\n";
}

// 1: orange
// 2: banana
// 3: apple