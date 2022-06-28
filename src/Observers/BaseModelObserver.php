<?php

namespace Laka\Core\Observers;

use Laka\Core\Entities\BaseModel;

class BaseModelObserver
{
    public function creating(BaseModel $baseModel)
    {
        $baseModel->setCreatedUpdatedUsers();
        $baseModel->listenCreating();
    }

    /**
     * Handle the base model "saving" event.
     *
     * @param  \Laka\BaseModel  $baseModel
     * @return void
     */
    public function saving(BaseModel $baseModel)
    {
        $baseModel->setCreatedUpdatedUsers();
        $baseModel->listenSaving();
    }

    /**
     * Handle the base model "updated" event.
     *
     * @param  \Laka\BaseModel  $baseModel
     * @return void
     */
    public function updating(BaseModel $baseModel)
    {
        $baseModel->setCreatedUpdatedUsers();
        $baseModel->listenUpdating();
    }

    /**
     * Handle the base model "created" event.
     *
     * @param  \Laka\BaseModel  $baseModel
     * @return void
     */
    public function created(BaseModel $baseModel)
    {
        $baseModel->listenCreated();
    }

    /**
     * Handle the base model "deleted" event.
     *
     * @param  \Laka\BaseModel  $baseModel
     * @return void
     */
    public function deleted(BaseModel $baseModel)
    {
    }
}
