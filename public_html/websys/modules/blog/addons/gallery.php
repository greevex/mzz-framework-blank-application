<?php
class galleryLookup extends blogLookupController
{
    public function lookup()
    {
        $galleryMapper = $this->toolkit->getMapper('gallery', 'photo');
        $criteria = new criteria;
        $criteria->where('date', (microtime() - 60*60*24), criteria::GREATER);
        $all = $galleryMapper->searchAllByCriteria($criteria);
        foreach($all as $a) {
            var_dump($a->getTitle());
        }
    }
}
?>