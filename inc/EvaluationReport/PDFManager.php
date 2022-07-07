<?php
/**
 * Manage PDF view/download
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\EvaluationReport
 */

namespace Tutor_Periscope\EvaluationReport;

use Dompdf\Dompdf;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * PDF render
 */
class PDFManager {

	/**
	 * Render pdf
	 *
	 * @since v2.0.0
	 *
	 * @param string $content  content for rendering.
	 * @param string $file_name pdf file name.
	 * @param bool   $download  if false then it will show pdf.
	 * @param string $size page size default A4.
	 * @param string $orientation  page orientation default landscape.
	 *
	 * @return void
	 */
	public static function render( string $content, string $file_name, $download = false, $size = 'A4', $orientation = 'portrait' ): void {
		// instantiate and use the dompdf class.
		$dompdf = new Dompdf();

		$options = $dompdf->getOptions();
		$options->setIsRemoteEnabled( 'true ' );

		$dompdf->loadHtml( $content );
		// (Optional) Setup the paper size and orientation.
		$dompdf->setPaper( $size, $orientation );
		// Render the HTML as PDF.
		$dompdf->render();
		// Output the generated PDF to Browser.
		$f;
		$l;
		if(headers_sent($f,$l))
		{
			echo $f,'<br/>',$l,'<br/>';
			die('now detect line');
		}
		if ( false === $download ) {
			$dompdf->stream( $file_name, array( 'Attachment' => 0 ) );
		} else {
			$dompdf->stream( $file_name );
		}
	}
}
