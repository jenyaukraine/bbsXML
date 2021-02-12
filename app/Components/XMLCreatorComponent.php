<?php
namespace App\Components;

class XMLCreatorComponent {
    public static function create($data)
    {
        print_r($data);

        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');

        xmlwriter_start_element($xw, 'ArticleSet');

        xmlwriter_start_element($xw, 'Journal');

            xmlwriter_start_element($xw, 'PublisherName');
            xmlwriter_text($xw, $data['PublisherName']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'JournalTitle');
            xmlwriter_text($xw, $data['JournalTitle']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'PISSN');
            xmlwriter_text($xw, $data['PISSN']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'EISSN');
            xmlwriter_text($xw, $data['EISSN']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'Volume');
            xmlwriter_text($xw, $data['Volume']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'Issue');
            xmlwriter_text($xw, $data['Issue']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'PubDate');
            xmlwriter_start_attribute($xw, 'PubStatus');
            xmlwriter_text($xw, 'epublish');
            xmlwriter_end_attribute($xw);

                xmlwriter_start_element($xw, 'Year');
                xmlwriter_text($xw, $data['PubDate']['Year']);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'Month');
                xmlwriter_text($xw, $data['PubDate']['Month']);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'Day');
                xmlwriter_text($xw, $data['PubDate']['Day']);
                xmlwriter_end_element($xw);
             xmlwriter_end_element($xw);


        xmlwriter_end_element($xw); // Journal


        xmlwriter_start_element($xw, 'ArticleTitle');
        xmlwriter_text($xw, $data['ArticleTitle']);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw, 'FirstPage');
        xmlwriter_text($xw, $data['FirstPage']);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw, 'LastPage');
        xmlwriter_text($xw, $data['LastPage']);
        xmlwriter_end_element($xw);

        xmlwriter_start_element($xw, 'Language');
        xmlwriter_text($xw, $data['Language']);
        xmlwriter_end_element($xw);



        xmlwriter_start_element($xw, 'AuthorList');
          foreach ($data['AuthorList'] as $authour) {
              xmlwriter_start_element($xw, 'Author');
                  xmlwriter_start_element($xw, 'FirstName');
                  xmlwriter_text($xw, $authour['FirstName']);
                  xmlwriter_end_element($xw);

                  xmlwriter_start_element($xw, 'MiddleName');
                  xmlwriter_text($xw, $authour['MiddleName']);
                  xmlwriter_end_element($xw);

                  xmlwriter_start_element($xw, 'LastName');
                  xmlwriter_text($xw, $authour['LastName']);
                  xmlwriter_end_element($xw);

                  xmlwriter_start_element($xw, 'Affiliation');
                  xmlwriter_text($xw, $authour['Affiliation']);
                  xmlwriter_end_element($xw);

                  xmlwriter_start_element($xw, 'AuthorEmails');
                  xmlwriter_text($xw, $authour['AuthorEmails']);
                  xmlwriter_end_element($xw);

              xmlwriter_end_element($xw);
          }
        xmlwriter_end_element($xw);


        xmlwriter_start_element($xw, 'DOI');
        xmlwriter_text($xw, $data['DOI']);
        xmlwriter_end_element($xw);


        xmlwriter_start_element($xw, 'Abstract');
        xmlwriter_text($xw, $data['Abstract']);
        xmlwriter_end_element($xw);


        xmlwriter_start_element($xw, 'Keywords');
        xmlwriter_text($xw, $data['Keywords']);
        xmlwriter_end_element($xw);


        xmlwriter_start_element($xw, 'URLs');
            xmlwriter_start_element($xw, 'abstract');
            xmlwriter_text($xw, $data['abstractUrl']);
            xmlwriter_end_element($xw);

            xmlwriter_start_element($xw, 'Fulltext');
                xmlwriter_start_element($xw, 'pdf');
                xmlwriter_text($xw, $data['abstractPdf']);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
        xmlwriter_end_element($xw);


        xmlwriter_end_element($xw); // ArticleSet
        xmlwriter_end_document($xw);
        echo xmlwriter_output_memory($xw);
    }
}