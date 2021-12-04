<?php

namespace Drupal\node_json_data\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node_json_data\Form\ModuleConfigurationForm;

/**
 * Class ApiController
 * @package Drupal\node_json_data\Controller
 */
class ApiController {

  /**
   * @return JsonResponse
   */
  public function index($enteredApi, $enteredId) {
    
    $query = \Drupal::entityQuery('node')->condition('nid', $enteredId);        
    $nodes_ids = $query->execute();
    $nodeCondition = count($nodes_ids);
    
    // To get the API saved via configuration form.
    $savedApi['node_json_data.api'] = \Drupal::config('node_json_data.settings')->get('node_json_data.api');
    
    // To check whether the user entered correct API and a node that exist.
    if(($savedApi['node_json_data.api'] == $enteredApi) && $nodeCondition != 0){
      return new JsonResponse([ 'data' => $this->getData($enteredApi, $enteredId), 'method' => 'GET', 'status'=> 200]);
    }
    else{
      return new JsonResponse(['Error' => 'Please enter the correct API and Node', 'Status'=> 404]);
    }
  }

  /**
   * @return array
   */
  public function getData($enteredApi, $enteredId) {
    $result=[];
    $query = \Drupal::entityQuery('node')->condition('nid', $enteredId);        
    $nodes_ids = $query->execute();
    // To get the node id and description of the required node
    if ($nodes_ids) {
      foreach ($nodes_ids as $node_id) {
        $node = \Drupal\node\Entity\Node::load($node_id);
        $nodeds = $node->id();
        $result[] = [
          "id" => $node->id(),
          "description" => $node->getTitle(),
        ];
        
      }
    }
    return $result;
  }
}