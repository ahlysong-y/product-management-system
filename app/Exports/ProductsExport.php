<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ProductsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, ShouldAutoSize
{
    public function collection()
    {
        return Product::with('category')->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'barcode' => $product->barcode ?? 'N/A',
                'category' => $product->category?->name ?? 'Uncategorized',
                'quantity' => $product->qty,
                'unit_price' => number_format($product->price, 2),
                'total_value' => number_format($product->qty * $product->price, 2),
                'description' => $product->description ?? '',
                'created_date' => $product->created_at?->format('M d, Y') ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Name',
            'Barcode',
            'Category',
            'Quantity',
            'Unit Price',
            'Total Value',
            'Description',
            'Created Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        // Header styling (Row 1)
        $sheet->getStyle('A1:I1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563eb'], // Blue background
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // White text
                'size' => 12,
                'name' => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Set header row height
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Data rows styling
        $highestRow = $sheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            // Alternating row colors
            $backgroundColor = ($row % 2 === 0) ? 'f9fafb' : 'ffffff';

            $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $backgroundColor],
                ],
                'font' => [
                    'size' => 10,
                    'name' => 'Calibri',
                    'color' => ['rgb' => '333333'],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'border' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'e5e7eb'],
                    ],
                ],
            ]);

            // Center align ID column
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Right align numeric columns
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Set row height
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // Add summary section
        $summaryRow = $highestRow + 2;
        $sheet->setCellValue('D' . $summaryRow, 'SUMMARY');
        $sheet->getStyle('D' . $summaryRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '1e40af'],
            ],
        ]);

        // Total Products
        $sheet->setCellValue('D' . ($summaryRow + 1), 'Total Products:');
        $sheet->setCellValue('E' . ($summaryRow + 1), $highestRow - 1);
        $this->styleSummaryRow($sheet, $summaryRow + 1);

        // Total Quantity
        $sheet->setCellValue('D' . ($summaryRow + 2), 'Total Quantity:');
        $sheet->setCellValue('E' . ($summaryRow + 2), '=SUM(E2:E' . $highestRow . ')');
        $this->styleSummaryRow($sheet, $summaryRow + 2);

        // Average Price
        $sheet->setCellValue('D' . ($summaryRow + 3), 'Average Price:');
        $sheet->setCellValue('E' . ($summaryRow + 3), '=AVERAGE(F2:F' . $highestRow . ')');
        $sheet->getStyle('E' . ($summaryRow + 3))->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->styleSummaryRow($sheet, $summaryRow + 3);

        // Total Inventory Value
        $sheet->setCellValue('D' . ($summaryRow + 4), 'Total Inventory Value:');
        $sheet->setCellValue('E' . ($summaryRow + 4), '=SUM(G2:G' . $highestRow . ')');
        $sheet->getStyle('E' . ($summaryRow + 4))->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563eb'],
            ],
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('E' . ($summaryRow + 4))->getNumberFormat()->setFormatCode('$#,##0.00');

        // Freeze header row
        $sheet->freezePane('A2');

        return $sheet;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,    // ID
            'B' => 25,   // Product Name
            'C' => 16,   // Barcode
            'D' => 16,   // Category
            'E' => 12,   // Quantity
            'F' => 12,   // Unit Price
            'G' => 14,   // Total Value
            'H' => 30,   // Description
            'I' => 14,   // Created Date
        ];
    }

    private function styleSummaryRow(Worksheet $sheet, int $row)
    {
        $sheet->getStyle('D' . $row . ':E' . $row)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'f0f9ff'],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '1e40af'],
            ],
            'border' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'bfdbfe'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(18);
    }
}
