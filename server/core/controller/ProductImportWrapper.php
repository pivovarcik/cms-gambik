<?php

// Obecná obálka pro import produktu
class ProductImportWrapper {

	// je pouze variantou k produktu
	public $isVarianty = false;

	// obsahuje seznam varaint
	public $variantyList = array();

	// je položka produktem
	public $isProduct = true;


	// schránka pro údaje o produktu
	public $product = null;

	// schránka pro údaje o variantě
	public $varianty = null;
}