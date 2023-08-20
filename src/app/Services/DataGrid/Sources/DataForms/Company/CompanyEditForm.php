<?php

namespace Bitex\Admin\DataForms\Company;

use Bitex\UI\FormGrid\FormGrid;

class CompanyEditForm extends FormGrid
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addRows()
    {
        $this->addRow([
            'type' => 'flex',
            'fields' => [
                $this->addField([
                    'label' => 'Наименование компании',
                    'type' => 'input',
                    'placeholder' => 'Введите что то',
                    'name' => 'company_name'
                ]),
                $this->addField([
                    'label' => 'БИК банка',
                    'type' => 'input',
                    'placeholder' => 'Введите что то',
                    'name' => 'bank_bik'
                ]),
            ]
        ]);
    }
}