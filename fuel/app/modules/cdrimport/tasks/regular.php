<?php

namespace Fuel\Tasks;

class Regular
{

    public static function CDR_Import()
    {
        // Make sure we have a good enough memory limit and the Import module is loaded
        ini_set('memory_limit','512M');
        \Module::load('CDRImport');


        $cdrPath = DOCROOT."public/uploads/cdr/";

        $hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
        $username = "cdr@clixsolutions.co.uk";
        $password = "Clix2013";

        $inbox = \imap_open($hostname, $username, $password) or die("No imap to gmail connection");
        $emails = \imap_search($inbox, "ALL");

        if ($emails)
        {
            rsort($emails);
            foreach ($emails as $email_number)
            {
                $overview = imap_fetch_overview($inbox,$email_number,0);
                $message = imap_fetchbody($inbox,$email_number,2);

                if (!$overview[0]->seen)
                {
                    $subjectLine = $overview[0]->subject;

                    $structure = imap_fetchstructure($inbox, $email_number);

                    $attachments = array();

                    /* if any attachments found... */
                    if(isset($structure->parts) && count($structure->parts))
                    {
                        for($i = 0; $i < count($structure->parts); $i++)
                        {
                            $attachments[$i] = array(
                                'is_attachment' => false,
                                'filename' => '',
                                'name' => '',
                                'attachment' => ''
                            );

                            if($structure->parts[$i]->ifdparameters)
                            {
                                foreach($structure->parts[$i]->dparameters as $object)
                                {
                                    if(strtolower($object->attribute) == 'filename')
                                    {
                                        $attachments[$i]['is_attachment'] = true;
                                        $attachments[$i]['filename'] = $object->value;
                                    }
                                }
                            }

                            if($structure->parts[$i]->ifparameters)
                            {
                                foreach($structure->parts[$i]->parameters as $object)
                                {
                                    if(strtolower($object->attribute) == 'name')
                                    {
                                        $attachments[$i]['is_attachment'] = true;
                                        $attachments[$i]['name'] = $object->value;
                                    }
                                }
                            }

                            if($attachments[$i]['is_attachment'])
                            {
                                $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                                /* 4 = QUOTED-PRINTABLE encoding */
                                if($structure->parts[$i]->encoding == 3)
                                {
                                    $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                                }
                                /* 3 = BASE64 encoding */
                                elseif($structure->parts[$i]->encoding == 4)
                                {
                                    $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                                }
                            }
                        }
                    }


                    /* iterate through each attachment and save it */
                    foreach($attachments as $attachment)
                    {
                        if($attachment['is_attachment'] == 1)
                        {
                            $filename = $attachment['name'];
                            if(empty($filename)) $filename = $attachment['filename'];

                            if(empty($filename)) $filename = time() . ".dat";

                            /* prefix the email number to the filename in case two emails
                             * have the attachment with the same file name.
                             */
                            $fp = fopen($cdrPath . $filename, "w+");
                            fwrite($fp, $attachment['attachment']);
                            fclose($fp);

                            preg_match_all('~[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}~', $subjectLine, $matches);

                            $date = $matches[0][0];

                            $splitDate = explode("/", $date);
                            $setDate = date('Y-m-d', strtotime($splitDate[2]."-".$splitDate[1]."-".$splitDate[0]));

                            // Open the ZIP file
                            $zip = new \ZipArchive();
                            $x = $zip->open($cdrPath . $filename);

                            if ($x === true)
                            {
                                // Extract the csv from the zip file
                                $zip->extractTo($cdrPath, array("tmp/Daily_CDRs.csv"));
                                $zip->close();

                                // Import the csv file
                                $imported = new \CDRImport\Cdr("tmp/Daily_CDRs.csv", $setDate);

                                // Delete the files that we extracted
                                \File::delete_dir($cdrPath."tmp/", true, true);

                            }
                            else
                            {
                                // Throw an error
                                throw new \Exception("Zip File Failed");
                            }



                        }

                    }



                }

            }
        }




    }

}