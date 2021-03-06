<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2016, Hoa community. All rights reserved.
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

namespace Hoa\Graph\Test\Unit\Iterator;

use Hoa\Graph as LUT;
use Mock\Hoa\Graph\Iterator\Generic as SUT;
use Hoa\Test;

/**
 * Class \Hoa\Graph\Test\Unit\Iterator\Generic.
 *
 * Test suite of the generic iterator class.
 *
 * @copyright  Copyright © 2007-2016 Hoa community
 * @license    New BSD License
 */
class Generic extends Test\Unit\Suite
{
    public function case_constructor()
    {
        $this
            ->given(
                $graph = new LUT\AdjacencyList(),
                $n1    = new LUT\SimpleNode('n1'),
                $graph->addNode($n1)
            )
            ->when($result = new SUT($graph, $n1))
            ->then
                ->object($result->getGraph())
                    ->isIdenticalTo($graph)
                ->object($result->getStartingNode())
                    ->isIdenticalTo($n1);
    }

    public function case_constructor_with_an_invalid_starting_node()
    {
        $this
            ->given(
                $graph = new LUT\AdjacencyList(),
                $n1    = new LUT\SimpleNode('n1')
            )
            ->exception(function () use ($graph, $n1) {
                new SUT($graph, $n1);
            })
                ->isInstanceOf(LUT\Exception::class);
    }
}
