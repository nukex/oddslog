<?php
declare(strict_types=1);

class SitemapController extends ControllerBase
{
    const  LIMIT =   10000;

    public function initialize() {
        $this->response->setHeader("Content-Type", "text/xml");
        $this->view->setRenderLevel( \Phalcon\Mvc\View::LEVEL_ACTION_VIEW );
       
    }
  
    
    public function SitemapsAction()
    {
        $count = Matchs::count();

        for ($i=1; $i <= ceil($count/self::LIMIT); $i++) { 
            $urls [] = 'https://' . $_SERVER['HTTP_HOST'] . "/sitemap-{$i}.xml";
        }
        $this->view->urls = $urls;
        $this->view->pick('index/sitemaps');
    }


    public function SitemapAction()
    {
        $currentPage = $this->dispatcher->getParam('page') ;

        $matchs = Matchs::listSitemap($currentPage, self::LIMIT);
        $this->view->matchs = $matchs->paginate()->getItems();
        $this->view->pick('index/sitemap');
    }

}

