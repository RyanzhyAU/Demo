<?php
class ControllerShippingEnquiryShipping extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('shipping/enquiryShipping');

		$this->document->setTitle($this->language->get('heading_title_normal'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('enquiryShipping', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['shipping_name'] = $this->language->get('shipping_name');
		$this->data['flat_cost'] = $this->language->get('flat_cost');
		$this->data['free_total'] = $this->language->get('free_total');
		$this->data['free_category'] = $this->language->get('free_category');
		$this->data['always_free'] = $this->language->get('always_free');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/enquiryShipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/enquiryShipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		

		/* Shipping name */
		if (isset($this->request->post['enquiryShipping_shipping_name'])) {
			$this->data['enquiryShipping_shipping_name'] = $this->request->post['enquiryShipping_shipping_name'];
		} else {
			$this->data['enquiryShipping_shipping_name'] = $this->config->get('enquiryShipping_shipping_name');
		}

		/* Flat cost */
		if (isset($this->request->post['enquiryShipping_flat_cost'])) {
			$this->data['enquiryShipping_flat_cost'] = $this->request->post['enquiryShipping_flat_cost'];
		} else {
			$this->data['enquiryShipping_flat_cost'] = $this->config->get('enquiryShipping_flat_cost');
		}

		/* Free total */
		if (isset($this->request->post['enquiryShipping_free_total'])) {
			$this->data['enquiryShipping_free_total'] = $this->request->post['enquiryShipping_free_total'];
		} else {
			$this->data['enquiryShipping_free_total'] = $this->config->get('enquiryShipping_free_total');
		}

		/* Free category */
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(array());
		
		if (isset($this->request->post['enquiryShipping_free_category'])) {
			$this->data['enquiryShipping_free_category'] = $this->request->post['enquiryShipping_free_category'];
		} else {
			$this->data['enquiryShipping_free_category'] = $this->config->get('enquiryShipping_free_category');
		}
		
		/* Always free */
		if (isset($this->request->post['enquiryShipping_always_free'])) {
			$this->data['enquiryShipping_always_free'] = $this->request->post['enquiryShipping_always_free'];
		} else {
			$this->data['enquiryShipping_always_free'] = $this->config->get('enquiryShipping_always_free');
		}
		

		/* Geo zones */
		$this->load->model('localisation/geo_zone');
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['enquiryShipping_geo_zone_id'])) {
			$this->data['enquiryShipping_geo_zone_id'] = $this->request->post['enquiryShipping_geo_zone_id'];
		} else {
			$this->data['enquiryShipping_geo_zone_id'] = $this->config->get('enquiryShipping_geo_zone_id');
		}
		
		/* Tax class */
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		if (isset($this->request->post['enquiryShipping_tax_class_id'])) {
			$this->data['enquiryShipping_tax_class_id'] = $this->request->post['enquiryShipping_tax_class_id'];
		} else {
			$this->data['enquiryShipping_tax_class_id'] = $this->config->get('enquiryShipping_tax_class_id');
		}
		
		/* Default */
		if (isset($this->request->post['enquiryShipping_status'])) {
			$this->data['enquiryShipping_status'] = $this->request->post['enquiryShipping_status'];
		} else {
			$this->data['enquiryShipping_status'] = $this->config->get('enquiryShipping_status');
		}
		
		if (isset($this->request->post['enquiryShipping_sort_order'])) {
			$this->data['enquiryShipping_sort_order'] = $this->request->post['enquiryShipping_sort_order'];
		} else {
			$this->data['enquiryShipping_sort_order'] = $this->config->get('enquiryShipping_sort_order');
		}				

		$this->template = 'shipping/enquiryShipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/trinone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>