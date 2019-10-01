<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 *
 *  Breadcrumbs library for CodeIgniter
 *  =============================================================
 *
 *  manages a breadcrumb list.
 *  data will be stored in the session
 *
 */

class Breadcrumbs {



  /**
   * The number of breadcrumbs will be limited to this amount.
   * set via setMaxBreadcrumbs()
   */
  private $maxBreadcrumbs  = 5;



  /**
   * if set to true, duplicates will be removed.
   * if set to false, duplicates stay in the path.  
   * set via setRemoveDuplicates() 
   */
  private $removeDuplicates = true;



  /**
   * classes to be added to the anchor link created by placeBreadcrumb()
   * set via setLinkClasses()
   */
  private $linkClasses = "";


  /**
   * This method can be used to place a breadcrumb text 
   * directly without further processing the input
   */  
  public function placeBreadcrumbText ( $breadcrumb ){

    $breadcrumbdata = $this -> retrieveBreadcrumbs();

    if ( $this -> removeDuplicates ) {
      // check whether new element already is in our list    
      $index = array_search ( $breadcrumb, $breadcrumbdata );
      if ( false !== $index ) {
        // already present. Delete, so it can be added on top
        unset ( $breadcrumbdata [ $index ] );
      }    
    }
  
    // put new element on top
    array_push ($breadcrumbdata, $breadcrumb );
    
    // make sure there are no more than maxBreadcrumbs elements in the path
    while ( count ( $breadcrumbdata ) > $this -> maxBreadcrumbs ) { 
      array_shift ( $breadcrumbdata ); 
    }

    $this -> storeBreadcrumbs( $breadcrumbdata );

  }



  /**
   * places a breadcrumb link with given url and title 
   * into the breadcrumb list
   * url and title will be combined to an anchor link
   */ 
  public function placeBreadcrumb ( $url, $title ){
    
    $attributes = array (
      "title" => $title,
    );

    if ( "" != $this -> linkClasses ){
      $attributes [ "class" ] = $this -> linkClasses;
    }

    $newBreadcrumb = anchor ( $url, $title, $attributes );

    $this -> placeBreadcrumbText ( $newBreadcrumb );
  
  } 



  /**
   * reads breadcrumb data from the current session
   * initializes empty breadcrumb data if there are no breadcrumb entries yet.
   */
  public function retrieveBreadcrumbs (){

    $breadcrumbdata = get_instance() -> session -> userdata ('breadcrumbs');

    // make sure a valid array is returned even if the session data is not set yet
    if ( "" == $breadcrumbdata) { return array(); }

    // split and return session data
    return explode ( ",", $breadcrumbdata );

  }



  /**
   * stores breadcrumb data into the current session
   * expects the parameter to be array. Everything else will not be stored.
   */
  public function storeBreadcrumbs ( $breadcrumbdata = null ){

    $storedata = "";

    // build data string if array is given
    if ( is_array ( $breadcrumbdata ) ) {
      $storedata = implode  (",", $breadcrumbdata );
    }

    // save to session
    get_instance() -> session -> set_userdata ('breadcrumbs', $storedata );

  }


  /**
   * reorganizes the breadcrumb data to match the current rules
   */
  public function reorganize(){

    // get current breadcrumbs
    $currentData = $this -> retrieveBreadcrumbs();

    // initialize breadcrumb list in session
    $this -> storeBreadcrumbs ( null );

    // re-add breadcrumbs, thus applying the current rules 
    foreach ( $currentData as $breadcrumb ){
      $this -> placeBreadcrumbText ( $breadcrumb );
    }

    // each breadcrumb is automatically stored to the session, 
    // no need to save here 
  }



  // ===========================================================
  //    Getters/Setters
  // ===========================================================


  /**
   * Sets the method to handle duplicates.
   * true (default): duplicates will be removed
   * false: duplicates stay and appear more than once in the path
   * reorganizes the breadcrumb and deletes duplicates if nesseciary
   */
  public function setRemoveDuplicates ( $removeDuplicates ){ 

    $this -> removeDuplicates = $removeDuplicates; 
    $this -> reorganize();

  }

  /**
   * Sets the maximum number of breadcrumbs in the path.
   * reorganizes the breadcrumb path to fit the new maximum length.
   */
  public function setMaxBreadcrumbs( $maxBreadcrumbs ){

    if (!is_numeric( $maxBreadcrumbs ) ) { return; }

    $this -> maxBreadcrumbs = $maxBreadcrumbs;
    $this -> reorganize();

  }



  /**
   * sets the classes to be added to the links created by placeBreadcrumb()
   */
  public function setLinkClasses( $classes ){
    $this -> linkClasses = $classes;
  }



}

