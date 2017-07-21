<?php
namespace ZendVN\Paginator;
class Paginator{
	public static function createPaginator($totalItem,$paginatorParams){
		$adapter    = new \Zend\Paginator\Adapter\Null($totalItem);
        $paginator  = new \Zend\Paginator\Paginator($adapter);

        
        $paginator->setCurrentPageNumber($paginatorParams['currentPageNumber']);
        $paginator->setPageRange($paginatorParams['pageRange']);
        $paginator->setItemCountPerPage($paginatorParams['itemCountPerPage']);
        return $paginator;
	}
}
