<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

/**
 * Test cases for class Product.
 */
class ProductTest extends TestCase
{
    /**
     * Test getId and ensure it returns null for a new entity
     */
    public function testGetId(): void
    {
        $product = new Product();
        $this->assertNull($product->getId());
    }

    /**
     * Test setting and getting the name
     */
    public function testSetAndGetName(): void
    {
        $product = new Product();
        $name = 'Test Product';

        $product->setName($name);
        $this->assertSame($name, $product->getName());
    }

    /**
     * Test setting and getting the value
     */
    public function testSetAndGetValue(): void
    {
        $product = new Product();
        $value = 100;

        $product->setValue($value);
        $this->assertSame($value, $product->getValue());
    }
}
