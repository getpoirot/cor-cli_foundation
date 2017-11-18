<?php
namespace Module\CliFoundation\Parser;

use Module\CliFoundation\Command;
use Module\CliFoundation\Interfaces\iCommand;
use Module\CliFoundation\Interfaces\iParser;


/**
 * PARSE ARGUMENTS
 *
 * This command line option parser supports any combination of three types
 * of options (switches, flags and arguments) and returns a simple array.
 *
 * [pfisher ~]$ php test.php --foo --bar=baz
 *   ["foo"]   => true
 *   ["bar"]   => "baz"
 *
 * [pfisher ~]$ php test.php -abc
 *   ["a"]     => true
 *   ["b"]     => true
 *   ["c"]     => true
 *
 * [pfisher ~]$ php test.php arg1 arg2 arg3
 *   [0]       => "arg1"
 *   [1]       => "arg2"
 *   [2]       => "arg3"
 *
 * [pfisher ~]$ php test.php plain-arg --foo --bar=baz --funny="spam=eggs" --also-funny=spam=eggs \
 * > 'plain arg 2' -abc -k=value "plain arg 3" --s="original" --s='overwrite' --s
 *   [0]       => "plain-arg"
 *   ["foo"]   => true
 *   ["bar"]   => "baz"
 *   ["funny"] => "spam=eggs"
 *   ["also-funny"]=> "spam=eggs"
 *   [1]       => "plain arg 2"
 *   ["a"]     => true
 *   ["b"]     => true
 *   ["c"]     => true
 *   ["k"]     => "value"
 *   [2]       => "plain arg 3"
 *   ["s"]     => "overwrite"
 *
 * @author              Patrick Fisher <patrick@pwfisher.com>
 * @since               August 21, 2009
 * @see                 http://www.php.net/manual/en/features.commandline.php
 *                      #81042 function arguments($argv) by technorati at gmail dot com, 12-Feb-2008
 *                      #78651 function getArgs($args) by B Crawford, 22-Oct-2007
 * @usage               $args = CommandLine::parseArgs($_SERVER['argv']);
 */
class ArgParser
    implements iParser
{
    /**
     * Parse Input To Command
     *
     * @param $input
     *
     * @return iCommand
     */
    function parseToCommand($input)
    {
        $command = new Command('request-command');

        foreach ($input as $arg) {
            // --foo --bar=baz
            if (substr($arg, 0, 2) == '--')
            {
                $eqPos = strpos($arg, '=');

                // --foo
                if ($eqPos === false) {
                    $key   = substr($arg, 2);
                    $value = isset($out[$key]) ? $out[$key] : true;
                }

                // --bar=baz
                else {
                    $key   = substr($arg, 2, $eqPos-2);
                    $value = substr($arg, $eqPos+1);
                }

                $command->addFlag(new Command\FlagOption($key, $value));
            }
            // -k=value -abc
            else if (substr($arg, 0, 1) == '-')
            {
                // -k=value
                if (substr($arg,2,1) == '=') {
                    $key   = substr($arg, 1, 1);
                    $value = substr($arg, 3);

                    $command->addFlag(new Command\FlagOption($key, $value));
                }
                // -abc
                else {
                    $chars = str_split(substr($arg, 1));
                    foreach ($chars as $char){
                        $key   = $char;

                        $command->addFlag(new Command\FlagOption($key, true));
                    }
                }
            }
            // plain-arg
            else {
                $value = $arg;

                $command->addArg(new Command\Argument($value));
            }
        }


        return $command;
    }
}
