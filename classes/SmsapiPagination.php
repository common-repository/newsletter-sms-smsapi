<?php

class SmsapiPagination
{
    protected $id;

    protected $items_per_page_list;

    protected $config = array(
        'current_page'      => array('source' => 'query_string', 'key' => 'p'),
        'total_items'       => 0,
        'items_per_page'    => 10,
        'items_per_page_list' => array( 10 => 10, 20 => 20, 50 => 50, 100 => 100 ),
        'view'              => 'pagination/basic',
        'auto_hide'         => TRUE,
        'hidden_for_not_enouth_items' => FALSE,
        'first_page_in_url' => FALSE,
    );

    protected $current_page;

    protected $total_items;

    protected $items_per_page;

    protected $total_pages;

    protected $current_first_item;

    protected $current_last_item;

    protected $previous_page;

    protected $next_page;

    protected $first_page;

    protected $last_page;

    protected $offset;

    protected $id_prefix;

    public function __construct(array $config = array())
    {
        $config = $this->config = $config + $this->config;

        if (isset($config['id'])) {
            $idPrefix = smsapi_array_safe_get($this->config, 'id_prefix', '');
            $this->id = $idPrefix.'pagination_' . $config['id'];
        }

        if ($this->current_page === NULL OR isset($config['current_page']) OR isset($config['total_items']) OR isset($config['items_per_page'])) {

            if (!empty($this->config['current_page']['page'])) {
                $this->current_page = (int) $this->config['current_page']['page'];
            } else {
                $this->current_page = isset($_GET[$this->config['current_page']['key']]) ? intval($_GET[$this->config['current_page']['key']]) : 1;
            }

            $this->total_items = (int) max(0, $this->config['total_items']);
            $this->items_per_page = (int) max(1, $this->config['items_per_page']);
            $this->total_pages = (int) ceil($this->total_items / $this->items_per_page);
            $this->current_page = (int) min(max(1, $this->current_page), max(1, $this->total_pages));
            $this->current_first_item = (int) min((($this->current_page - 1) * $this->items_per_page) + 1, $this->total_items);
            $this->current_last_item = (int) min($this->current_first_item + $this->items_per_page - 1, $this->total_items);
            $this->previous_page = ($this->current_page > 1) ? $this->current_page - 1 : FALSE;
            $this->next_page = ($this->current_page < $this->total_pages) ? $this->current_page + 1 : FALSE;
            $this->first_page = ($this->current_page === 1) ? FALSE : 1;
            $this->last_page = ($this->current_page >= $this->total_pages) ? FALSE : $this->total_pages;
            $this->offset = (int) (($this->current_page - 1) * $this->items_per_page);
            $this->items_per_page_list = (array) $this->config['items_per_page_list'];
        }

        return $this;
    }

    public function __get($key)
    {
        if ($key == 'elements') {
            $key = 'items_per_page_list';
        }

        return isset($this->$key) ? $this->$key : null;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        if (smsapi_array_safe_get($this->config, 'hidden_for_not_enouth_items') AND $this->total_items <= min($this->items_per_page_list)) {
            return '';
        }

        if ($this->config['auto_hide'] === true AND $this->total_pages <= 1) {
            return '';
        }

        ob_start();

        extract(get_object_vars($this));
        $page = $this;

        include SMSAPI_PLUGIN_PATH . '/views/pagination/basic.php';

        return ob_get_clean();
    }

    public function getLimit()
    {
        return $this->items_per_page;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function url($page = 1)
    {
        $page = max(1, (int) $page);

        if ($page === 1 AND !$this->config['first_page_in_url']) {
            $page = null;
        }

        if ($page) {
            return sprintf('%s&%s=%s', $this->config['base_url'], $this->config['current_page']['key'], $page);
        } else {
            return sprintf('%s', $this->config['base_url']);
        }
    }

    public function valid_page($page)
    {
        return $page > 0 AND $page <= $this->total_pages;
    }
}