<?php

namespace App\Shared\Application;

interface ApplicationService
{
    /**
     * @param ApplicationServiceRequest $request
     * @return ApplicationServiceResponse
     */
    public function execute(ApplicationServiceRequest $request) : ApplicationServiceResponse;
}
