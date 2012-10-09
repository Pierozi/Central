<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2012, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace {

from('Hoa')

/**
 * \Hoa\File\Read
 */
-> import('File.Read')

/**
 * \Hoa\Compiler\Llk
 */
-> import('Compiler.Llk.~')

/**
 * \Hoa\Math\Visitor\Arithmetic
 */
-> import('Math.Visitor.Arithmetic')

/**
 * \Hoa\Compiler\Visitor\Dump
 */
-> import('Compiler.Visitor.Dump');

}

namespace Hoa\Math\Bin {

/**
 * Class \Hoa\Math\Bin\Calc.
 *
 * A simple calculator.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2012 Ivan Enderlin.
 * @license    New BSD License
 */

class Calc extends \Hoa\Console\Dispatcher\Kit {

    /**
     * Options description.
     *
     * @var \Hoa\Math\Bin\Calc array
     */
    protected $options = array(
        array('help', \Hoa\Console\GetOption::NO_ARGUMENT, 'h'),
        array('help', \Hoa\Console\GetOption::NO_ARGUMENT, '?')
    );



    /**
     * The entry method.
     *
     * @access  public
     * @return  int
     */
    public function main ( ) {

        while(false !== $c = $this->getOption($v)) switch($c) {

            case 'h':
            case '?':
                return $this->usage();
              break;

            case '__ambiguous':
                $this->resolveOptionAmbiguity($v);
              break;
        }

        $this->parser->listInputs($expression);

        $compiler = \Hoa\Compiler\Llk::load(
            new \Hoa\File\Read('hoa://Library/Math/Arithmetic.pp')
        );
        $visitor  = new \Hoa\Math\Visitor\Arithmetic();
        $dump     = new \Hoa\Compiler\Visitor\Dump();

        if(null !== $expression) {

            $ast = $compiler->parse($expression);
            cout($expression . ' = ' . $visitor->visit($ast));

            return;
        }

        $handle     = null;
        $expression = 'h';

        do {

            switch($expression) {

                case 'h':
                case 'help':
                    cout('Usage:');
                    cout('    h[elp]       to print this help;');
                    cout('    c[onstants]  to print available constants;');
                    cout('    f[unctions]  to print available functions;');
                    cout('    e[xpression] to print the current expression;');
                    cout('    d[ump]       to dump the tree of the expression;');
                    cout('    q[uit]       to quit.');
                  break;

                case 'c':
                case 'constants':
                    cout(implode(', ', array_keys(
                        $visitor->getConstants()->getArrayCopy()
                    )));
                  break;

                case 'f':
                case 'functions':
                    cout(implode(', ', array_keys(
                        $visitor->getFunctions()->getArrayCopy()
                    )));
                  break;

                case 'e':
                case 'expression':
                    cout($handle);
                  break;

                case 'd':
                case 'dump':
                    if(null === $handle)
                        cout('Type a valid expression before (“> 39 + 3”).');
                    else
                        cout($dump->visit($compiler->parse($handle)));
                  break;

                case 'q':
                case 'quit':
                    cout('Bye bye!');
                  break 2;

                default:
                    if(null === $expression)
                        break;

                    try {

                        cout($visitor->visit($compiler->parse($expression)));
                    }
                    catch ( \Hoa\Compiler\Exception $e ) {

                        cout($e->getFormattedMessage());

                        break;
                    }

                    $handle = $expression;
                  break;
            }

        } while('quit' !== $expression = $this->readLine('> '));

        return;
    }

    /**
     * The command usage.
     *
     * @access  public
     * @return  int
     */
    public function usage ( ) {

        cout('Usage   : math:calc <options> [expression]');
        cout('Options :');
        cout($this->makeUsageOptionsList(array(
            'help' => 'This help.'
        )));

        return;
    }
}

}

__halt_compiler();
A simple calculator.