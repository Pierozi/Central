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

namespace Hoa\Xyl\Interpreter\Html;

/**
 * Class \Hoa\Xyl\Interpreter\Html\Async.
 *
 * The <async /> component.
 *
 * @copyright  Copyright © 2007-2016 Hoa community
 * @license    New BSD License
 */
class Async extends Form
{
    /**
     * Attributes description.
     *
     * @var array
     */
    protected static $_attributes        = [
        'scope' => parent::ATTRIBUTE_TYPE_NORMAL
    ];

    /**
     * Attributes mapping between XYL and HTML.
     *
     * @var array
     */
    protected static $_attributesMapping = [
        'scope' => 'data-asyncscope',
    ];



    /**
     * Pre-execute an element.
     *
     * @return  void
     */
    public function preExecute()
    {
        $this->writeAttribute('data-async', 'true');
        parent::preExecute();

        return;
    }

    /**
     * Get component name.
     *
     * @return  string
     */
    public function getName()
    {
        return 'form';
    }
}
