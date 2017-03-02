<?php

namespace AppBundle\Utils;

class SimpleXMLElement extends \SimpleXMLElement
{
    /**
     * @param string $cdata_text
     */
    public function addCData($cdata_text) {
        $node = dom_import_simplexml($this);
        $no   = $node->ownerDocument;
        $node->appendChild($no->createCDATASection($cdata_text));
    }
}
