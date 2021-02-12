<?php

namespace App\Components;

use App\Components\CurlGetterComponent;
use voku\helper\HtmlDomParser;
use function simplehtmldom_1_5\file_get_html;

class ParseBbsComponent
{

    private $curlGetter;
    private $website;
    private $domParser;

    public function __construct($url)
    {
        $this->curlGetter = new CurlGetterComponent;
        $this->website = $url;
    }

    public function run()
    {
//        $result = $this->curlGetter->getWebsite($this->website);
//
//        file_put_contents('text.txt', $result);
        $result = file_get_contents('text.txt');

        $dom = HtmlDomParser::str_get_html($result);

        $PublisherName = 'LLC "CPC "Business Perspectives"';
        $JournalTitle = '';

        $ArticleTitle = $dom->findOne('h1')->innerHtml();


        $firstPage = $dom->findOne('meta[name="citation_firstpage"]')->getAttribute('content');
        $lastPage = $dom->findOne('meta[name="citation_lastpage"]')->getAttribute('content');
        $volume = $dom->findOne('meta[name="citation_volume"]')->getAttribute('content');

        $pubdate = $dom->findOne('meta[name="citation_publication_date"]')->getAttribute('content');

        $EISSN = str_replace('-', '', $dom->findOne('meta[name="citation_issn"]')->getAttribute('content'));
        $issn = str_replace('-', '', $dom->findOne('issn[media_type="print"]')->text());


        $DOI = $dom->findOne('li[data-zoocart-id="9d254ae3-ea9e-474c-bbbf-656b90b1620c"] > .txt')->text();
        $DOI = str_replace('http://dx.doi.org/', '', $DOI);

        $Abstract = $dom->findOne('.large-text > p')->innerHtml();

        $Keywords = $dom->findOne('li[data-zoocart-id="_itemtag"] > .txt')->text();

        $abstractUrl = $this->website;
        $abstractPdf = $dom->findOne('meta[name="citation_pdf_url"]')->getAttribute('content');


        $author = $dom->findMulti('meta[name="citation_author"]');
        $authName = [];
        foreach ($author as $a)
        {
            $authName[] = $a->getAttribute('content'). PHP_EOL;
        }

        $authorAF = $dom->findMulti('meta[name="citation_author_affiliation"]');
        $authAF = [];
        foreach ($authorAF as $a)
        {
            $authAF[] = $a->getAttribute('content'). PHP_EOL;
        }

        foreach ($authName as $key => $t) {
            print_r($t. " : : : ". $authAF[$key] . PHP_EOL);
        }



    }
}