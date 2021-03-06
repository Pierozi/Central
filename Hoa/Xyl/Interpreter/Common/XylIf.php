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

namespace Hoa\Xyl\Interpreter\Common;

use Hoa\Stream;
use Hoa\Xyl;

/**
 * Class \Hoa\Xyl\Interpreter\Common\XylIf.
 *
 * The <if /> component.
 *
 * @copyright  Copyright © 2007-2016 Hoa community
 * @license    New BSD License
 */
class XylIf extends Xyl\Element\Concrete
{
    /**
     * Attributes description.
     *
     * @var array
     */
    protected static $_attributes = [
        'test' => self::ATTRIBUTE_TYPE_NORMAL
    ];



    /**
     * Paint the element.
     *
     * @param   \Hoa\Stream\IStream\Out  $out    Out stream.
     * @return  void
     */
    public function paint(Stream\IStream\Out $out)
    {
        return $this->structuralCompute($out);
    }

    /**
     * Structural compute (if/elseif/else).
     *
     * @param   \Hoa\Stream\IStream\Out  $out    Out stream.
     * @return  void
     */
    public function structuralCompute(Stream\IStream\Out $out)
    {
        $verdict = false;

        if (true === $this->abstract->attributeExists('test')) {
            $verdict = Xyl::evaluateXPath(
                $this->computeAttributeValue(
                    $this->abstract->readAttribute('test'),
                    self::ATTRIBUTE_TYPE_NORMAL
                )
            );
        }

        if (false === $verdict) {
            $next = $this->abstract->selectAdjacentSiblingElement('elseif')
                        ?: $this->abstract->selectAdjacentSiblingElement('else');

            if (false === $next) {
                return;
            }

            $this->getConcreteElement($next)->structuralCompute($out);

            return;
        }

        $this->computeValue($out);

        return;
    }
}
