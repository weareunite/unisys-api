<?php

namespace Unite\UnisysApi\Services;

use Barryvdh\Snappy\PdfWrapper as PDF;

class PdfService extends Service
{
    protected $PDF;

    const DEFAULT_FILENAME = 'document.pdf';

    public function __construct(PDF $PDF)
    {
        $this->PDF = $PDF;
        $this->PDF->setPaper('a4')
                ->setOrientation('portrait');
    }

    public function setOption($name, $value)
    {
        $this->PDF->setOption($name, $value);
        return $this;
    }

    public function create(String $view, array $data = [])
    {
        return $this->PDF->loadView($view, $data);
    }

    public function stream()
    {
        return $this->PDF->inline();
    }

    public function output()
    {
        return $this->PDF->output();
    }

    public function download(String $filename = self::DEFAULT_FILENAME)
    {
        return $this->PDF->download($filename);
    }

    public function save(String $filename = self::DEFAULT_FILENAME, $overwrite = false)
    {
        return $this->PDF->save($filename, $overwrite);
    }
}