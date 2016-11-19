<?php
namespace Gungnir\DataSource;

interface DataSourceOperationInterface 
{
	/**
	 * Runs the operation and returns the result
	 * 
	 * @return mixed
	 */
	public function execute();
}