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
class CallAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by'    => 'createdAt'
    );

    private $statuses = array(
        0 => 'In progress',
        1 => 'Finished',
        2 => 'Failed',
        3 => 'Aborted',
        4 => 'Resolved'
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
            ->add('process.id')
            ->add('process.commandName')
            ->add('createdAt')
            ->add('finishedAt')
            ->add('executionTime')
            ->add('status', null, array(), 'choice', array(
                'choices' => $this->statuses
            ))
            ->add('output')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('process', 'many_to_one', [
                'route' => [
                    'name' => 'show',
                ],
                'associated_property' => 'command',
                'sortable' => true,
                'sort_field_mapping' => array(
                    'fieldName' => 'command'
                ),
                'sort_parent_association_mappings' => array(
                    array('fieldName' => 'process'),
                )
            ])
            ->add('consolePid')
            ->add('status', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:call_status_field.html.twig'
            ))
            ->add('ExecutionTimeProportion', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:call_execution_time_proportion.html.twig'
            ))
            ->add('executionTime', null, array(
                'template' => 'ConsoleProcessManagerSonataAdminBundle:CRUD:execution_time_field.html.twig'
            ))
            ->add('createdAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('finishedAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('output', 'html', array(
                'truncate' => array(
                    'preserve' => true
                )
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array()
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('consolePid')
            ->add('process.commandName')
            ->add('process', 'many_to_one', [
                'route' => [
                    'name' => 'show',
                ]
            ])
            ->add('createdAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('finishedAt', null, array('format' => 'Y-m-d H:i:s'))
            ->add('executionTimeToString', null, ['label' => 'Execution Time'])
            ->add('process.avgExecutionTimeToString', null, ['label' => 'Average Process Execution Time'])
            ->add('status', 'choice', array(
                'choices' => $this->statuses
            ))
            ->add('output')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $finishedAt = $formMapper->getAdmin()->getSubject()->getFinishedAt()
            ? $formMapper->getAdmin()->getSubject()->getFinishedAt() : new \DateTime();

        $formMapper
            ->add('finishedAt', 'sonata_type_datetime_picker', array(
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                    'dp_side_by_side' => false,
                    'dp_use_current' => true,
                    'dp_use_seconds' => true,
                    'data' => $finishedAt
                )
            )
            ->add('status', 'choice', array(
                'expanded' => true,
                'choices' => $this->statuses
            ))
            ->add('executionTime', 'integer', array(
                'empty_data' => ($finishedAt->getTimestamp()
                    - $formMapper->getAdmin()->getSubject()->getCreatedAt()->getTimestamp()
            )))
        ;
    }
}
