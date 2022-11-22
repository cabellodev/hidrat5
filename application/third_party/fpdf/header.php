<?php

class PDF extends FPDF
{
	/* Page header */
	function Header()
	{
		/* Logo */
		$this->Image('logo.png',10,6,30);

	}
}

?>