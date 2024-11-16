<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleInItTeam: string
{
    case BACKEND_DEVELOPER = 'Backend Developer';
    case FRONTEND_DEVELOPER = 'Frontend Developer';
    case QA = 'QA';
    case DEVOPS = 'DevOps';
    case TEAM_LEAD = 'Team Lead';
    case PROJECT_MANAGER = 'Project Manager';
    case SEO_SPECIALIST = 'SEO Specialist';
    case ACCOUNTANT = 'Accountant';
    case DESIGNER = 'Designer';
    case BUSINESS_ANALYST = 'Business Analyst';
}