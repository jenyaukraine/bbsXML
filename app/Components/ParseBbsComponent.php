<?php

namespace App\Components;

use App\Components\CurlGetterComponent;
use voku\helper\HtmlDomParser;
use App\Components\XMLCreatorComponent;

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
        $JournalTitle = $dom->findOne('meta[name="citation_journal_title"]')->getAttribute('content');
        $PISSN = str_replace('-', '', $dom->findOne('issn[media_type="print"]')->text());
        $EISSN = str_replace('-', '', $dom->findOne('meta[name="citation_issn"]')->getAttribute('content'));
        $Volume = $dom->findOne('meta[name="citation_volume"]')->getAttribute('content');
        $Issue = $dom->findOne('meta[name="citation_issue"]')->getAttribute('content');


        $pubdate = $dom->findOne('meta[name="citation_publication_date"]')->getAttribute('content');

        $pubdate = explode('/', $pubdate);

        $PubDate = [
            'Year' => $pubdate[0],
            'Month' => $pubdate[1],
            'Day' => $pubdate[2],
        ];

        $ArticleTitle = $dom->findOne('h1')->innerHtml();

        $FirstPage = $dom->findOne('meta[name="citation_firstpage"]')->getAttribute('content');
        $LastPage = $dom->findOne('meta[name="citation_lastpage"]')->getAttribute('content');

        $Language = 'EN';

        //Authour case

        $authorAF = $dom->findMulti('meta[name="citation_author_affiliation"]');
        $authAF = [];
        foreach ($authorAF as $a) {
            $authAF[] = $a->getAttribute('content');
        }

        $author = $dom->findMulti('meta[name="citation_author"]');
        $AuthorList = [];
        foreach ($author as $key => $a) {
            $Author = [];
            $depdata = explode(' ', $a->getAttribute('content'));

            $Author['FirstName'] = array_shift($depdata);
            $Author['LastName'] = array_pop($depdata);
            $Author['MiddleName'] = implode(' ', $depdata);
            $Author['Affiliation'] = $authAF[$key];
            $Author['AuthorEmails'] = '';

            $AuthorList[] = $Author;
        }


        // End Authour


        $DOI = $dom->findOne('li[data-zoocart-id="9d254ae3-ea9e-474c-bbbf-656b90b1620c"] > .txt')->text();
        $DOI = str_replace('http://dx.doi.org/', '', $DOI);

        $Abstract = $dom->findOne('.large-text > p')->innerHtml();

        $Keywords = $dom->findOne('li[data-zoocart-id="_itemtag"] > .txt')->text();

        $abstractUrl = $this->website;
        $abstractPdf = $dom->findOne('meta[name="citation_pdf_url"]')->getAttribute('content');

        XMLCreatorComponent::create(compact('PublisherName', 'JournalTitle', 'PISSN', 'EISSN', 'Volume', 'Issue',
            'PubDate', 'ArticleTitle', 'FirstPage', 'LastPage', 'Language', 'AuthorList', 'DOI', 'Abstract', 'Keywords' ,'abstractUrl', 'abstractPdf'));

    }
}