<?php 

namespace Product\Controller;

use Product\Model\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Product\Form\ProductForm;
use Product\Model\Product;

class ProductController extends AbstractActionController
{
	private $table;

	public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
    	$data['products'] = $this->table->fetchAll();
    	$data['software'] = array('one','two','three');
    	return new ViewModel($data);
    }

    public function addAction()
    {
    	$form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveAlbum($product);
        return $this->redirect()->toRoute('product');

    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}

?>