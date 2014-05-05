<?php

class CKANClient {

  function __construct($base_url, $api_key = null, $user_agent = 'ckan-script') {
    $this->base_url = $base_url;
    $this->api_key = $api_key;
    $this->user_agent = $user_agent;
  }

  //
  // Read methods
  //

  function site_read() {
    return $this->_request('site_read');
  }

  function package_list($limit = null, $offset = null) {
    return $this->_request('package_list', array(
      'limit' => $limit,
      'offset' => $offset
    ));
  }

  function current_package_list_with_resources($limit = null, $offset = null) {
    return $this->_request('current_package_list_with_resources', array('limit' => $limit, 'offset' => $offset));
  }

  function revision_list() {
    return $this->_request('revision_list');
  }

  function package_revision_list($id) {
    return $this->_request('package_revision_list', array('id' => $id));
  }

  function related_show($id) {
    return $this->_request('related_show', array('id' => $id));
  }

  // FIXME dataset parameter is probably wrong
  function related_list($id = null, $dataset = null, $type_filter = null, $sort = null, $featured = null) {
    return $this->_request('related_list', array('id' => $id, 'dataset' => $dataset, 'type_filter' => $type_filter, 'sort' => $sort, 'featured' => $featured));
  }

  function member_list($id, $object_type = null, $capacity = null) {
    return $this->_request('member_list', array('id' => $id, 'object_type' => $object_type, 'capacity' => $capacity));
  }

  // FIXME groups is probably wrong
  function group_list($order_by = null, $sort = null, $groups = null, $all_fields = null) {
    return $this->_request('group_list', array('order_by' => $order_by, 'sort' => $sort, 'groups' => $groups, 'all_fields' => $all_fields));
  }

  // FIXME organizations is probably wrong
  function organization_list($order_by = null, $sort = null, $organizations = null, $all_fields = null) {
    return $this->_request('organization_list', array('order_by' => $order_by, 'sort' => $sort, 'organizations' => $organizations, 'all_fields' => $all_fields));
  }

  function organization_list_for_user($permission = null) {
    return $this->_request('organization_list_for_user', array('permission' => $permission));
  }

  function group_revision_list($id) {
    return $this->_request('group_revision_list', array('id' => $id));
  }

  function organization_revision_list($id) {
    return $this->_request('organization_revision_list', array('id' => $id));
  }

  function license_list() {
    return $this->_request('license_list');
  }

  function tag_list($query = null, $vocabulary_id = null, $all_fields = null) {
    return $this->_request('tag_list', array('query' => $query, 'vocabulary_id' => $vocabulary_id, 'all_fields' => $all_fields));
  }

  function user_list($q = null, $order_by = null) {
    return $this->_request('user_list',  array('q' => $q, 'order_by' => $order_by));
  }

  function package_relationships_list($id, $id2, $rel = null) {
    return $this->_request('package_relationships_list', array('id' => $id, 'id2' => $id2, 'rel' => $rel));
  }

  function package_show($id, $use_default_schema = null) {
    return $this->_request('package_show', array('id' => $id, 'use_default_schema' => $use_default_schema));
  }

  function resource_show($id) {
    return $this->_request('resource_show', array('id' => $id));
  }

  function resource_status_show($id) {
    return $this->_request('resource_status_show', array('id' => $id));
  }

  function revision_show($id) {
    return $this->_request('revision_show', array('id' => $id));
  }

  function group_show($id) {
    return $this->_request('group_show', array('id' => $id));
  }

  function organization_show($id) {
    return $this->_request('organization_show', array('id' => $id));
  }

  function group_package_show($id, $limit = null) {
    return $this->_request('group_package_show', array('id' => $id, 'limit' => $limit));
  }

  function tag_show($id) {
    return $this->_request('tag_show', array('id' => $id));
  }

  // FIXME user_obj is probably wrong
  function user_show($id = null, $user_obj = null) {
    return $this->_request('user_show', array('id' => $id, 'user_obj' => $user_obj));
  }

  function package_autocomplete($q, $limit = null) {
    return $this->_request('package_autocomplete', array('q' => $q, 'limit' => $limit));
  }

  function format_autocomplete($q, $limit = null) {
    return $this->_request('format_autocomplete', array('q' => $q, 'limit' => $limit));
  }

  function user_autocomplete($q, $limit = null) {
    return $this->_request('user_autocomplete', array('q' => $q, 'limit' => $limit));
  }

  function package_search (){
    // FIXME
    return $this->_request('package_search', array());
  }

  function user_search (){
    // FIXME
    return $this->_request('user_search', array());
  }

  function tag_search (){
    // FIXME
    return $this->_request('tag_search', array());
  }

  function tag_autocomplete (){
    // FIXME
    return $this->_request('tag_autocomplete', array());
  }

  function task_status_show (){
    // FIXME
    return $this->_request('task_status_show', array());
  }

  function term_translation_show (){
    // FIXME
    return $this->_request('term_translation_show', array());
  }

  function roles_show (){
    // FIXME
    return $this->_request('roles_show', array());
  }

  function status_show (){
    // FIXME
    return $this->_request('status_show', array());
  }

  function vocabulary_list (){
    // FIXME
    return $this->_request('vocabulary_list', array());
  }

  function vocabulary_show (){
    // FIXME
    return $this->_request('vocabulary_show', array());
  }

  function user_activity_list (){
    // FIXME
    return $this->_request('user_activity_list', array());
  }

  function package_activity_list (){
    // FIXME
    return $this->_request('package_activity_list', array());
  }

  function group_activity_list (){
    // FIXME
    return $this->_request('group_activity_list', array());
  }

  function organization_activity_list (){
    // FIXME
    return $this->_request('organization_activity_list', array());
  }

  function recently_changes_packages_activity_list (){
    // FIXME
    return $this->_request('recently_changes_packages_activity_list', array());
  }

  function activity_detail_list (){
    // FIXME
    return $this->_request('activity_detail_list', array());
  }

  function user_activity_list_html (){
    // FIXME
    return $this->_request('user_activity_list_html', array());
  }

  function package_activity_list_html (){
    // FIXME
    return $this->_request('package_activity_list_html', array());
  }

  function group_activity_list_html (){
    // FIXME
    return $this->_request('group_activity_list_html', array());
  }

  function organization_activity_list_html (){
    // FIXME
    return $this->_request('organization_activity_list_html', array());
  }

  function recently_changed_packages_activity_list_html (){
    // FIXME
    return $this->_request('recently_changed_packages_activity_list_html', array());
  }

  function user_follower_count (){
    // FIXME
    return $this->_request('user_follower_count', array());
  }

  function dataset_follower_count (){
    // FIXME
    return $this->_request('dataset_follower_count', array());
  }

  function group_follower_count (){
    // FIXME
    return $this->_request('group_follower_count', array());
  }

  function user_follower_list (){
    // FIXME
    return $this->_request('user_follower_list', array());
  }

  function dataset_follower_list (){
    // FIXME
    return $this->_request('dataset_follower_list', array());
  }

  function group_follower_list (){
    // FIXME
    return $this->_request('group_follower_list', array());
  }

  function am_following_user (){
    // FIXME
    return $this->_request('am_following_user', array());
  }

  function am_following_dataset (){
    // FIXME
    return $this->_request('am_following_dataset', array());
  }

  function am_following_group (){
    // FIXME
    return $this->_request('am_following_group', array());
  }

  function followee_count (){
    // FIXME
    return $this->_request('followee_count', array());
  }

  function user_followee_count (){
    // FIXME
    return $this->_request('user_followee_count', array());
  }

  function dataset_followee_count (){
    // FIXME
    return $this->_request('dataset_followee_count', array());
  }

  function group_followee_count (){
    // FIXME
    return $this->_request('group_followee_count', array());
  }

  function followee_list (){
    // FIXME
    return $this->_request('followee_list', array());
  }

  function user_followee_list (){
    // FIXME
    return $this->_request('user_followee_list', array());
  }

  function dataset_followee_list (){
    // FIXME
    return $this->_request('dataset_followee_list', array());
  }

  function group_followee_list (){
    // FIXME
    return $this->_request('group_followee_list', array());
  }

  function dashboard_activity_list (){
    // FIXME
    return $this->_request('dashboard_activity_list', array());
  }

  function dashboard_new_activities_count (){
    // FIXME
    return $this->_request('dashboard_new_activities_count', array());
  }

  function member_roles_list (){
    // FIXME
    return $this->_request('member_roles_list', array());
  }

  //
  // Create methods
  //

  function package_create($name, $owner_org, $options) {
    $options['name'] = $name;
    $options['owner_org'] = $owner_org;
    return $this->_request('package_create', $options);
  }

  function resource_create($package_id, $url, $options) {
    $options['package_id'] = $package_id;
    $options['url'] = $url;
    return $this->_request('resource_create', $options);
  }

  // related_create
  // package_relationship_create
  // member_create

  function group_create($name, $options) {
    $options['name'] = $name;
    return $this->_request('group_create', $options);
  }

  // organization_create
  // rating_create
  // user_create
  // user_invite
  // vocabulary_create
  // activity_create
  // tag_create
  // follow_user
  // follow_dataset
  // group_member_create
  // organization_member_create
  // follow_group

  //
  // Update methods
  //

  // make_latest_pending_package_active
  // related_update
  // resource_update

  function package_update($name, $owner_org, $options) {
    $options['name'] = $name;
    $options['owner_org'] = $owner_org;
    return $this->_request('package_update', $options);
  }

  // package_resource_reorder
  // package_relationship_update

  function group_update($name, $options) {
    $options['name'] = $name;
    return $this->_request('group_update', $options);
  }

  // group_update
  // organization_update
  // user_update
  // task_status_update
  // task_status_update_many
  // term_translation_update
  // term_translation_update_many
  // vocabulary_update
  // user_role_update
  // user_role_bulk_update
  // dashboard_mark_activities_old
  // send_email_notifications
  // package_owner_org_update
  // bulk_update_private
  // bulk_update_public
  // bulk_update_delete
  // 

  //
  // Delete methods
  //

  // user_delete
  // package_delete
  // resource_delete
  // package_relationship_delete
  // related_delete
  // member_delete
  // group_delete
  // organization_delete
  // group_purge
  // organization_purge
  // task_status_delete
  // vocabulary_delete
  // tag_delete
  // unfollow_user
  // unfollow_dataset
  // group_member_delete
  // organization_member_delete
  // unfollow_group

  private function _request($command, $params = array()) {
    // set up the URL
    $url = sprintf("%s/api/3/action/%s", $this->base_url, $command);

    // set up options
    $params = $this->_strip_null_params($params);
    $options = array(
      'http' => array (
        'ignore_errors' => true,
        'method' => 'POST',
        'header' => "User-Agent: {$this->user_agent}\r\n" .
                    "Authorization: {$this->api_key}\r\n" .
                    "Content-type: text/json\r\n",
        'content' => json_encode($params),
      ),
    );

    if (!$params) {
      $options['http']['content'] = '{}';
    }

    $json = file_get_contents($url, false, stream_context_create($options));

    return json_decode($json)->result;
  }

  private function _strip_null_params($params_in) {
    $params_out = array();
    foreach ($params_in as $key => $value) {
      if ($value != null) {
        $params_out[$key] = $value;
      }
    }
    return $params_out;
  }
  
}
