<?php

namespace myBundle\ictBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use myBundle\ictBundle\Entity\activity;
use myBundle\ictBundle\Form\activityType;

/**
 * activity controller.
 *
 */
class activityController extends Controller
{
	/**
	 * Lists all activity entities.
	 *
	 */
	    public function mainAction()
	    {
	
	    	$config = new \Doctrine\DBAL\Configuration();
	    	//..
// 	    	$connectionParams = array(
// 	    			'dbname' => 'da3v7s01hiaill',
// 	    			'user' => 'thepuufhlxlnip',
// 	    			'password' => 'pm_O_tcQrPN9M67Nq_A2cXfIJH',
// 	    			'host' => 'ec2-54-204-31-13.compute-1.amazonaws.com',
// 	    			'driver' => 'pdo_pgsql',
// 	    	);
	    	$connectionParams = array(
	    			'dbname' => 'd2cugdbsibkams',
	    			'user' => 'rrtbmylvvfcjqn',
	    			'password' => 'CuiEON4wbdTm5KION9QF0reZId',
	    			'host' => 'ec2-54-243-51-102.compute-1.amazonaws.com',
	    			'driver' => 'pdo_pgsql',
	    	);
	    	$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
	    	$conn->beginTransaction();
	    	$stmt = $conn->prepare('SELECT * FROM activity order by popular desc');
	    	$stmt->execute();
	    	$new_entities = array();
	    	while($entity = $stmt->fetch())
	    	{
// 	    		array_push($new_entities, $entity);
    			flush();
//     			$fp = @fopen($entity->getURL(), "r");
    			$fp = @fopen($entity['url'], "r");
				if ($fp !== false)
    			{
    				array_push($new_entities, $entity);
    				// echo "Link works";
    			}
    			else
    			{
//     				$entity->setURL("invalid link");
    				$entity['url']="invalid link";
    				array_push($new_entities, $entity);
    				// 	echo"Link doesn't work";
    			}
    			@fclose($fp);
	    	}
	    	return $this->render('myBundleictBundle:Default:parent_act.html.twig', array(
	    			'entities' => $new_entities,));
	    }	
// 	public function mainAction()
// 	{
// 		$em = $this->getDoctrine()->getManager();
	
// 		$entities = $em->getRepository('myBundleictBundle:activity')->findAll();
// 		$new_entities = array();
// 		foreach($entities as $entity)
// 		{
// 			flush();
// 			$fp = @fopen($entity->getURL(), "r");
				
// 			if ($fp !== false)
// 			{
// 				array_push($new_entities, $entity);
// 				// 				echo "Link works";
// 			}
// 			else
// 			{
// 				$entity->setURL("invalid link");
// 				array_push($new_entities, $entity);
// 				// 				echo"Link doesn't work";
// 			}
// 			@fclose($fp);
// 		}		
		
		
// 		return $this->render('myBundleictBundle:Default:parent_act.html.twig', array(
// 				'entities' => $new_entities,
// 		));
// 	}
    /**
     * Lists all activity entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('myBundleictBundle:activity')->findAll();

        return $this->render('myBundleictBundle:activity:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new activity entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new activity();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('activity_show', array('id' => $entity->getId())));
        }

        return $this->render('myBundleictBundle:activity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a activity entity.
     *
     * @param activity $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(activity $entity)
    {
        $form = $this->createForm(new activityType(), $entity, array(
            'action' => $this->generateUrl('activity_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new activity entity.
     *
     */
    public function newAction()
    {
        $entity = new activity();
        $form   = $this->createCreateForm($entity);

        return $this->render('myBundleictBundle:activity:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a activity entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('myBundleictBundle:activity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find activity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('myBundleictBundle:activity:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activity entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('myBundleictBundle:activity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find activity entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('myBundleictBundle:activity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a activity entity.
    *
    * @param activity $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(activity $entity)
    {
        $form = $this->createForm(new activityType(), $entity, array(
            'action' => $this->generateUrl('activity_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing activity entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('myBundleictBundle:activity')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find activity entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('activity_edit', array('id' => $id)));
        }

        return $this->render('myBundleictBundle:activity:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Count popular an existing activity entity.
     *
     */
    public function countAction(Request $request, $id)
    {
//     	$em = $this->getDoctrine()->getManager();
    
//     	$entity = $em->getRepository('myBundleictBundle:activity')->find($id);
    
//     	if (!$entity) {
//     		throw $this->createNotFoundException('Unable to find activity entity.');
//     	}
//     	$entity->setPopular(($entity->getPopular())+1);
//     	$em->flush();
//     	$query = $em->createQuery(
//     			'SELECT c FROM myBundleictBundle:activity c ORDER BY c.popular DESC'
//     	);
    
//     	$entities = $query->getResult();
//     	return $this->render('myBundleictBundle:Default:parent_act.html.twig', array(
//     			'entities' => $entities,
//     	));
    	$config = new \Doctrine\DBAL\Configuration();
    	//..
    	// 	    	$connectionParams = array(
    	// 	    			'dbname' => 'da3v7s01hiaill',
    	// 	    			'user' => 'thepuufhlxlnip',
    	// 	    			'password' => 'pm_O_tcQrPN9M67Nq_A2cXfIJH',
    	// 	    			'host' => 'ec2-54-204-31-13.compute-1.amazonaws.com',
    	// 	    			'driver' => 'pdo_pgsql',
    	// 	    	);
    	$connectionParams = array(
    			'dbname' => 'd2cugdbsibkams',
    			'user' => 'rrtbmylvvfcjqn',
    			'password' => 'CuiEON4wbdTm5KION9QF0reZId',
    			'host' => 'ec2-54-243-51-102.compute-1.amazonaws.com',
    			'driver' => 'pdo_pgsql',
    	);
    	$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    	$conn->beginTransaction();
    	$stmt = $conn->prepare("SELECT * FROM activity where id=?");
    	$stmt->execute(array($id));
    	$new_entities = array();
    	$pop = 0;
    	while($entity = $stmt->fetch())
    	{   		
    		$pop = $entity['popular']+1;
    	}
//     	$stmt = $conn->query($str);
//     	$stmt->execute();
//     	$new_entities = array();
//     	$entity = $stmt->fetch();
// //     	$count = $conn->executeUpdate('UPDATE activity SET popular = ? WHERE id = ?', array(0, 1));
//     	$stmt = $conn->executeUpdate("Update activity set popular = ? where id=?", array($pop, $id));
    	$stmt = $conn->update('activity', array('popular' => $pop), array('id' => $id));
    	$conn->commit();
    	// UPDATE user (username) VALUES (?) WHERE id = ? (jwage, 1)
//     	$stmt = $conn->update( "activity", "popular", $pop);
//     	$stmt->execute();
// //     	$stmt->execute(array($popular,$id));
// //     	step select
    	$stmt = $conn->prepare('SELECT * FROM activity order by popular desc');
    	$stmt->execute();
    	$new_entities = array();
    	while($entity = $stmt->fetch())
    	{
    		// 	    		array_push($new_entities, $entity);
    		flush();
    		//     			$fp = @fopen($entity->getURL(), "r");
    		$fp = @fopen($entity['url'], "r");
    		if ($fp !== false)
    		{
    			array_push($new_entities, $entity);
    			// echo "Link works";
    		}
    		else
    		{
    			//     				$entity->setURL("invalid link");
    			$entity['url']="invalid link";
    			array_push($new_entities, $entity);
    			// 	echo"Link doesn't work";
    		}
    		@fclose($fp);
    	}
    	return $this->render('myBundleictBundle:Default:parent_act.html.twig', array(
    			'entities' => $new_entities,));
    }
    /**
     * Deletes a activity entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('myBundleictBundle:activity')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find activity entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('activity'));
    }

    /**
     * Creates a form to delete a activity entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activity_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
    //for test
    //     public function mainAction()
    //     {
    
    //     	$config = new \Doctrine\DBAL\Configuration();
    //     	//..
    //     	$connectionParams = array(
    //     			'dbname' => 'ICT',
    //     			'user' => 'postgres',
    		//     			'password' => 'admin',
    		//     			'host' => 'localhost',
    		//     			'driver' => 'pdo_pgsql',
    //     	);
    //     	$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    //     	$conn->beginTransaction();
    //     	$stmt = $conn->prepare('SELECT * FROM activity');
    //     	$stmt->execute();
    //     	$new_entities = array();
    //     	while($entity = $stmt->fetch())
    	//     	{
    	//     		array_push($new_entities, $entity);
    	//     		// 					flush();
    	//     		// 					$fp = @fopen($entity->getURL(), "r");
    
    	//     		// 					if ($fp !== false)
    		//     			// 							{
    		//     			// 								array_push($new_entities, $entity);
    		//     			// 								// 				echo "Link works";
    		//     			// 							}
    		//     		// 					else
    			//     			// 							{
    			//     			// 								$entity->setURL("invalid link");
    			//     			// 								array_push($new_entities, $entity);
    			//     			// 								// 				echo"Link doesn't work";
    			//     			// 							}
    			//     		// 					@fclose($fp);
    			//     	}
    //     	return $this->render('myBundleictBundle:Default:parent_act.html.twig', array(
    //     			'entities' => $new_entities,));
    //     } 
}
