<?php

namespace RedCircle\ConsoleProcessManagerSonataAdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @author Mateusz Krysztofiak <mateusz@krysztofiak.net>
 */
class ProcessAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by'    => 'updatedAt'
    );

    /**
     * Removing bath actions
     *
     * @return array
     */
    public function getBatchActions()
    {
        return [];
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('commandName')
            ->add('command')
            ->add('executionCounter')
            ->add('avgExecutionTime')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->add('id')
            ->add('command', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:link_to_calls_list_filtered_by_process_id.html.twig'
            ))
            ->add('executionCounter')
            ->add('avgExecutionTime', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:execution_time_field.html.twig'
            ))
            ->add('callErrorCount', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:red_label_if_exists.html.twig'
            ))
            ->add('callLastErrorTime', null, array('format' => 'Y-m-d H:i:s'))
            ->add('lastCall.status', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:call_status_field.html.twig'
            ))
            ->add('lastCall.ExecutionTimeProportion', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:call_execution_time_proportion.html.twig'
            ))
            ->add('lastCall.executionTime', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:execution_time_field.html.twig'
            ))
            ->add('lastCall.createdAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('lastCall.finishedAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('lastCall.output', 'html', array(
                'truncate' => array(
                    'preserve' => true
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('commandName')
            ->add('command')
            ->add('executionCounter')
            ->add('avgExecutionTime')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('commandName')
            ->add('command')
            ->add('executionCounter')
            ->add('avgExecutionTime')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

}
