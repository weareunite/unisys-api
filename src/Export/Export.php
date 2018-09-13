<?php

namespace Unite\UnisysApi\Export;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\Repositories\Repository;

class Export
{
    /** @var \Illuminate\Http\Request */
    protected $request;

    /** @var Repository */
    protected $repository;

    public function __construct(? Request $request = null)
    {
        $this->request = $request;
    }

    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    public function export()
    {
        $object = QueryBuilder::for($this->repository, $this->request)
            ->get();
        $columns = $this->request->get('columns') ? json_decode(base64_decode($this->request->get('columns'))) : null;
        if(!$columns) {
            return;
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('UniSys')
            ->setCompany('Unite, s.r.o')
            ->setTitle('UniSys export Title')
            ->setSubject('UniSys export Subject')
            ->setDescription('UniSys export Description');

        foreach($columns as $colIndex => $field) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow($colIndex+1, 1, $field->header);

            foreach($object as $rowIndex => $row) {
                $key = $field->key;
                $value = '';

                if ($field->key === 'tags') {
                    foreach ($row->tags as $i => $tag) {
                        if ($i === 0) {
                            $value .= $tag->name;
                        } else {
                            $value .= ', ' . $tag->name;
                        }
                    }
                } else {
                    if (str_contains($field->key, '/')) {
                        $value = '';
                        $a = explode('/', $field->key);
                        foreach ($row->{camel_case($a[0])} as $i => $b) {
                            if ($i === 0) {
                                $value .= $this->makeValue($b, $a[1]);
                            } else {
                                $value .= ', ' . $this->makeValue($b, $a[1]);
                            }
                        }
                    } else {
                        $value = $this->makeValue($row, $key);
                    }
                }
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
            }
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Export');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_'.time().'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    protected function makeValue($row, $key)
    {
        $value = '';

        $keys = explode('.', $key);

        $countKeys = count($keys);

        switch ($countKeys) {
            case 1:
                $value = $row->{$keys[0]};
                break;
            case 2:
                $value = $row->{$keys[0]}->{$keys[1]};
                break;
            case 3:
                $value = $row->{$keys[0]}->{$keys[1]}->{$keys[2]};
                break;
            case 4:
                $value = $row->{$keys[0]}->{$keys[1]}->{$keys[2]}->{$keys[3]};
                break;
        }

        return $value;
    }
}
