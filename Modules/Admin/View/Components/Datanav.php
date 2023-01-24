<?php
namespace Modules\Admin\View\Component;
use Illuminate\View\Component;
Use App\Dataset;

class Datanav extends Component
{
    public $datasets;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($datasets)
    {
        $this->datasets = $datasets;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin::components.datanav');
    }
}
