<?php
/**
 * Vtiger Web Services PHP Client Library (vtwsphpclib)
 *
 * Inspired by vtwsclib – vtiger CRM Web Services Client Library version 1.4
 * Build with Guzzle. Thanks!
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2015, Valentin Despa <info@vdespa.de>. All rights reserved.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    Valentin Despa <info@vdespa.de>
 * @copyright 2015 Valentin Despa <info@vdespa.de>
 * @license   The MIT License (MIT)
 */

namespace Vdespa\Vtiger\Domain\Model;

use Vdespa\Vtiger\Domain\Model\Field\ModuleFieldCollection;

class Module
{
    /**
     * Module name
     *
     * @var string
     */
    private $name;

    /**
     * Module label
     *
     * @var string
     */
    private $label;

    /**
     * @var bool
     */
    private $createable;

    /**
     * @var bool
     */
    private $updateable;

    /**
     * @var bool
     */
    private $deleteable;

    /**
     * @var bool
     */
    private $retrieveable;

    /**
     * Module prefix
     *
     * @var int
     */
    private $idPrefix;

    /**
     * @var bool
     */
    private $entity;

    /**
     * @var string
     */
    private $labelFields;

    /**
     * @var ModuleFieldCollection
     */
    private $fields;

    /**
     * Module constructor.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $label
     * @return Module
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param boolean $createable
     * @return Module
     */
    public function setCreateable($createable)
    {
        $this->createable = $createable;

        return $this;
    }

    /**
     * @param boolean $updateable
     * @return Module
     */
    public function setUpdateable($updateable)
    {
        $this->updateable = $updateable;

        return $this;
    }

    /**
     * @param boolean $deleteable
     * @return Module
     */
    public function setDeleteable($deleteable)
    {
        $this->deleteable = $deleteable;

        return $this;
    }

    /**
     * @param boolean $retrieveable
     * @return Module
     */
    public function setRetrieveable($retrieveable)
    {
        $this->retrieveable = $retrieveable;

        return $this;
    }

    /**
     * @param int $idPrefix
     * @return Module
     */
    public function setIdPrefix($idPrefix)
    {
        $this->idPrefix = $idPrefix;

        return $this;
    }

    /**
     * @param boolean $entity
     * @return Module
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @param string $labelFields
     * @return Module
     */
    public function setLabelFields($labelFields)
    {
        $this->labelFields = $labelFields;

        return $this;
    }

    /**
     * @param ModuleFieldCollection $fields
     * @return Module
     */
    public function setFields(ModuleFieldCollection $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}