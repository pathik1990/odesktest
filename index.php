<?php
$input = array(
    array(
        'Name'    => 'Trixie',
        'Color'   => 'Green',
        'Element' => 'Earth',
        'Likes'   => 'Flowers'
    ),
    array(
        'Name'    => 'Tinkerbell',
        'Element' => 'Air',
        'Likes'   => 'Singning',
        'Color'   => 'Blue'
    ),
    array(
        'Element' => 'Water',
        'Likes'   => 'Dancing',
        'Name'    => 'Blum',
        'Color'   => 'Pink'
    ),
    array(
        'Element' => 'Ferrum',
        'Likes'   => 'Programming',
        'Name'    => 'Aleksey',
        'Color'   => 'White'
    ),
);

class TablePrinter {

    protected $rows = array();
    protected $padding = 1;
    protected $headerAlign = 'center';

    public function __construct($rows, $padding = 1) {
        $this->rows = $rows;
        $this->padding = $padding;

        $this->columns = $this->_getColumns($rows);
    }

    public function printTable() {
        $output = $this->printHeader();
        $output .= $this->printBody();
        $output .= $this->printFooter();

        return $output;
    }
    
    public function sort($column, $direction = 'asc') {
        $values = array();
        foreach($this->rows as $row) {
            $values[] = $row[$column];
        }
        
        if($direction == 'desc') {
            $sortDirection = SORT_DESC;
        } else {
            $sortDirection = SORT_ASC;
        }
        
        array_multisort($values, $sortDirection, SORT_REGULAR, $this->rows);
    }

    public function printHeader() {
        $columnsTitles = array();
        foreach ($this->columns as $column) {
            $columnsTitles[$column['title']] = $column['title'];
        }

        $output = $this->_printLine();
        $output .= $this->_printRow($columnsTitles, $this->headerAlign);
        $output .= $this->_printLine();

        return $output;
    }

    public function printBody() {
        $output = '';
        foreach ($this->rows as $row) {
            $output .= $this->_printRow($row);
        }

        return $output;
    }

    public function printFooter() {
        $output = '';
        $output .= $this->_printLine();
        return $output;
    }

    protected function _printLine() {
        $columnsLines = array();
        foreach ($this->columns as $column) {
            $columnsLines[] = str_repeat('-', $column['size'] + ($this->padding * 2));
        }
        $output = implode('+', $columnsLines);
        $output = '+' . $output . '+' . "\n";

        return $output;
    }

    protected function _printRow($row, $align = 'left') {
        $valuesRow = array();
        foreach ($this->columns as $column) {
            $value = $row[$column['title']];
            $size = $column['size'];
            
            $valuesRow[] = $this->_printValue($row[$column['title']], $size, $align);
        }
        $output = implode('|', $valuesRow);
        $output = '|' . $output . '|' . "\n";

        return $output;
    }
    
    protected function _printValue($value, $size, $align) {
        $paddingLeft = str_repeat(' ', $this->padding);
        $paddingRight = str_repeat(' ', $this->padding);

        if($align == 'right') {
            $padType = STR_PAD_LEFT;
        } elseif($align == 'center') {
            $padType = STR_PAD_BOTH;
        } else { // left
            $padType = STR_PAD_RIGHT;
        }
        
        $output = $paddingLeft . str_pad($value, $size, ' ', $padType) . $paddingRight;
        
        return $output;
    }

    protected function _getColumns() {
        $columnsTitles = array();
        foreach ($this->rows as $row) {
            foreach ($row as $column => $value) {
                $columnsTitles[$column] = true;
            }
        }
        $columnsTitles = array_keys($columnsTitles);

        $columns = array();
        foreach ($columnsTitles as $columnTitle) {
            $columns[] = array(
                'title' => $columnTitle,
                'size'  => $this->_getColumnSize($columnTitle),
            );
        }

        return $columns;
    }

    protected function _getColumnSize($columnTitle) {
        $maxSize = strlen($columnTitle);

        foreach ($this->rows as $row) {
            if (isset($row[$columnTitle]) && strlen($row[$columnTitle]) > $maxSize) {
                $maxSize = strlen($row[$columnTitle]);
            }
        }

        return $maxSize;
    }
}


$printer = new TablePrinter($input);
$printer->sort('Name', 'asc');
echo $printer->printTable();

?>