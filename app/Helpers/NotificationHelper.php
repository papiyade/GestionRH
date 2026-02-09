<?php

namespace App\Helpers;

use App\Models\Task;
use Carbon\Carbon;

class NotificationHelper
{
    public static function getTaskNotifications($userId)
    {
        $now = Carbon::now();
        $notifications = [];
        
        // Récupérer les tâches de l'utilisateur
        $tasks = Task::whereHas('users', function($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where('status', '!=', 'completed')
            ->whereNotNull('deadline')
            ->with('project')
            ->get();

        foreach ($tasks as $task) {
            $deadline = Carbon::parse($task->deadline);
            $notificationId = 'task_' . $task->id . '_' . $deadline->format('Y-m-d');
            
            // Vérifier si déjà lue en session
            $readNotifications = session('read_notifications', []);
            if (in_array($notificationId, $readNotifications)) {
                continue; // Notification déjà lue
            }

            // Tâches en retard
            if ($deadline->isPast()) {
                $daysLate = (int) $deadline->startOfDay()->diffInDays($now->startOfDay());


                $notifications[] = [
                    'id' => $notificationId,
                    'type' => 'overdue',
                    'icon' => '🔴',
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'project_title' => $task->project->title ?? 'N/A',
                    'message' => "En retard de {$daysLate} jour(s)",
                    'deadline' => $deadline,
                    'url' => route('projects.show', $task->project_id),
                    'created_at' => $task->updated_at
                ];
            }
            // Tâches d'aujourd'hui
            elseif ($deadline->isToday()) {
                $notifications[] = [
                    'id' => $notificationId,
                    'type' => 'today',
                    'icon' => '⚠️',
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'project_title' => $task->project->title ?? 'N/A',
                    'message' => "Expire aujourd'hui à {$deadline->format('H:i')}",
                    'deadline' => $deadline,
                    'url' => route('projects.show', $task->project_id),
                    'created_at' => $task->updated_at
                ];
            }
            // Tâches de demain
            elseif ($deadline->isTomorrow()) {
                $notifications[] = [
                    'id' => $notificationId,
                    'type' => 'tomorrow',
                    'icon' => '📅',
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'project_title' => $task->project->title ?? 'N/A',
                    'message' => "Expire demain à {$deadline->format('H:i')}",
                    'deadline' => $deadline,
                    'url' => route('projects.show', $task->project_id),
                    'created_at' => $task->updated_at
                ];
            }
        }

        // Trier par priorité (overdue > today > tomorrow)
        usort($notifications, function($a, $b) {
            $priority = ['overdue' => 3, 'today' => 2, 'tomorrow' => 1];
            return ($priority[$b['type']] ?? 0) - ($priority[$a['type']] ?? 0);
        });

        return $notifications;
    }

    public static function markAsRead($notificationId)
    {
        $readNotifications = session('read_notifications', []);
        if (!in_array($notificationId, $readNotifications)) {
            $readNotifications[] = $notificationId;
            session(['read_notifications' => $readNotifications]);
        }
    }

    public static function markAllAsRead($notifications)
    {
        $readNotifications = session('read_notifications', []);
        foreach ($notifications as $notif) {
            if (!in_array($notif['id'], $readNotifications)) {
                $readNotifications[] = $notif['id'];
            }
        }
        session(['read_notifications' => $readNotifications]);
    }

    public static function clearOldRead()
    {
        // Nettoyer les notifications lues de plus de 7 jours
        $readNotifications = session('read_notifications', []);
        $cleaned = array_filter($readNotifications, function($id) {
            // Extraire la date de l'ID (format: task_123_2025-01-17)
            $parts = explode('_', $id);
            if (count($parts) === 3) {
                $date = Carbon::parse($parts[2]);
                return $date->diffInDays(Carbon::now()) <= 7;
            }
            return false;
        });
        session(['read_notifications' => array_values($cleaned)]);
    }
}