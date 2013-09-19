<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.6
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Tasks;

/**
 * Robot example task
 *
 * Ruthlessly stolen from the beareded Canadian sexy symbol:
 *
 *		Derek Allard: http://derekallard.com/
 *
 * @package		Fuel
 * @version		1.0
 * @author		Phil Sturgeon
 */


class Robots
{

// 19 PBX 20, 21 Diallers


    public static function Test_CDR_Import($filename)
    {
        // Make sure we have a good enough memory limit and the Import module is loaded
        ini_set('memory_limit','512M');
        \Module::load('CDRImport');


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
                print $overview[0]->subject . "\n";
            }
        }

        /*

        // Open the ZIP file
        $zip = new \ZipArchive();
        $x = $zip->open(DOCROOT."public/uploads/cdr/".$filename);

        if ($x === true)
        {
            // Extract the csv from the zip file
            $zip->extractTo(DOCROOT."public/uploads/cdr/", array("tmp/Daily_CDRs.csv"));
            $zip->close();

            // Import the csv file
            $imported = new \CDRImport\Cdr("tmp/Daily_CDRs.csv");

            // Delete the files that we extracted
            \File::delete_dir(DOCROOT."public/uploads/cdr/tmp/", true, true);

            // E-Mail a completed notification
            print_r($imported);
        }
        else
        {
            // Throw an error
            throw new \Exception("Zip File Failed");
        }

        */

    }


	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r robots
	 *
	 * or
	 *
	 * php oil r robots "Kill all Mice"
	 *
	 * @return string
	 */
	public static function run($speech = null)
	{
		if ( ! isset($speech))
		{
			$speech = 'KILL ALL HUMANS!';
		}

		$eye = \Cli::color("*", 'red');

		return \Cli::color("
					\"{$speech}\"
			          _____     /
			         /_____\\", 'blue')."\n"
.\Cli::color("			    ____[\\", 'blue').$eye.\Cli::color('---', 'blue').$eye.\Cli::color('/]____', 'blue')."\n"
.\Cli::color("			   /\\ #\\ \\_____/ /# /\\
			  /  \\# \\_.---._/ #/  \\
			 /   /|\\  |   |  /|\\   \\
			/___/ | | |   | | | \\___\\
			|  |  | | |---| | |  |  |
			|__|  \\_| |_#_| |_/  |__|
			//\\\\  <\\ _//^\\\\_ />  //\\\\
			\\||/  |\\//// \\\\\\\\/|  \\||/
			      |   |   |   |
			      |---|   |---|
			      |---|   |---|
			      |   |   |   |
			      |___|   |___|
			      /   \\   /   \\
			     |_____| |_____|
			     |HHHHH| |HHHHH|", 'blue');
	}

	/**
	 * An example method that is here just to show the various uses of tasks.
	 *
	 * Usage (from command line):
	 *
	 * php oil r robots:protect
	 *
	 * @return string
	 */
	public static function protect()
	{
		$eye = \Cli::color("*", 'green');

		return \Cli::color("
					\"PROTECT ALL HUMANS\"
			          _____     /
			         /_____\\", 'blue')."\n"
.\Cli::color("			    ____[\\", 'blue').$eye.\Cli::color('---', 'blue').$eye.\Cli::color('/]____', 'blue')."\n"
.\Cli::color("			   /\\ #\\ \\_____/ /# /\\
			  /  \\# \\_.---._/ #/  \\
			 /   /|\\  |   |  /|\\   \\
			/___/ | | |   | | | \\___\\
			|  |  | | |---| | |  |  |
			|__|  \\_| |_#_| |_/  |__|
			//\\\\  <\\ _//^\\\\_ />  //\\\\
			\\||/  |\\//// \\\\\\\\/|  \\||/
			      |   |   |   |
			      |---|   |---|
			      |---|   |---|
			      |   |   |   |
			      |___|   |___|
			      /   \\   /   \\
			     |_____| |_____|
			     |HHHHH| |HHHHH|", 'blue');

	}
}

/* End of file tasks/robots.php */
