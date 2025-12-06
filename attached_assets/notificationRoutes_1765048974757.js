const express = require('express');
const router = express.Router();
const { Op } = require('sequelize');
const BillingNotifications = require('../models/mysql/BillingNotifications');
const notificationScheduler = require('../services/notificationScheduler');
const adminSettingsService = require('../services/adminSettingsService');

router.get('/queue', async (req, res) => {
    try {
        const { status, page = 1, limit = 20, type } = req.query;
        const offset = (page - 1) * limit;
        
        const where = {};
        if (status) {
            where.status = status;
        }
        if (type) {
            where.notification_type = type;
        }
        
        const { count, rows } = await BillingNotifications.findAndCountAll({
            where,
            order: [['scheduled_at', 'DESC']],
            limit: parseInt(limit),
            offset: parseInt(offset)
        });
        
        res.json({
            success: true,
            data: rows,
            pagination: {
                total: count,
                page: parseInt(page),
                limit: parseInt(limit),
                pages: Math.ceil(count / limit)
            }
        });
    } catch (error) {
        console.error('Error getting notification queue:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/stats', async (req, res) => {
    try {
        const [pending, sent, failed, queued] = await Promise.all([
            BillingNotifications.count({ where: { status: 'pending' } }),
            BillingNotifications.count({ where: { status: 'sent' } }),
            BillingNotifications.count({ where: { status: 'failed' } }),
            BillingNotifications.count({ where: { status: 'queued' } })
        ]);
        
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const sentToday = await BillingNotifications.count({
            where: {
                status: 'sent',
                sent_at: { [Op.gte]: today }
            }
        });
        
        const failedToday = await BillingNotifications.count({
            where: {
                status: 'failed',
                updatedAt: { [Op.gte]: today }
            }
        });
        
        res.json({
            success: true,
            data: {
                pending,
                sent,
                failed,
                queued,
                sentToday,
                failedToday,
                schedulerRunning: notificationScheduler.isRunning
            }
        });
    } catch (error) {
        console.error('Error getting notification stats:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/retry/:id', async (req, res) => {
    try {
        const { id } = req.params;
        
        const notification = await BillingNotifications.findByPk(id);
        if (!notification) {
            return res.status(404).json({ success: false, message: 'Notification not found' });
        }
        
        if (notification.status !== 'failed') {
            return res.status(400).json({ success: false, message: 'Only failed notifications can be retried' });
        }
        
        await notification.update({
            status: 'pending',
            retry_count: 0,
            last_error: null,
            scheduled_at: new Date()
        });
        
        res.json({ success: true, message: 'Notification queued for retry' });
    } catch (error) {
        console.error('Error retrying notification:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/retry-all-failed', async (req, res) => {
    try {
        const result = await BillingNotifications.update(
            {
                status: 'pending',
                retry_count: 0,
                last_error: null,
                scheduled_at: new Date()
            },
            {
                where: { status: 'failed' }
            }
        );
        
        res.json({ success: true, message: `${result[0]} notifications queued for retry` });
    } catch (error) {
        console.error('Error retrying all notifications:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/scheduler/status', async (req, res) => {
    try {
        const config = adminSettingsService.getNotificationConfig();
        res.json({
            success: true,
            data: {
                isRunning: notificationScheduler.isRunning,
                config
            }
        });
    } catch (error) {
        console.error('Error getting scheduler status:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/scheduler/start', async (req, res) => {
    try {
        const config = adminSettingsService.getNotificationConfig();
        const intervalMs = config.intervalMs || 60000;
        
        await notificationScheduler.start(intervalMs);
        
        res.json({ success: true, message: 'Notification scheduler started' });
    } catch (error) {
        console.error('Error starting scheduler:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/scheduler/stop', async (req, res) => {
    try {
        notificationScheduler.stop();
        res.json({ success: true, message: 'Notification scheduler stopped' });
    } catch (error) {
        console.error('Error stopping scheduler:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.post('/scheduler/run-now', async (req, res) => {
    try {
        await notificationScheduler.processScheduledNotifications();
        await notificationScheduler.scheduleUpcomingNotifications();
        res.json({ success: true, message: 'Scheduler run completed' });
    } catch (error) {
        console.error('Error running scheduler:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.get('/types', async (req, res) => {
    try {
        const types = await BillingNotifications.findAll({
            attributes: ['notification_type'],
            group: ['notification_type']
        });
        res.json({ success: true, data: types.map(t => t.notification_type) });
    } catch (error) {
        console.error('Error getting notification types:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

router.delete('/:id', async (req, res) => {
    try {
        const { id } = req.params;
        await BillingNotifications.destroy({ where: { id } });
        res.json({ success: true, message: 'Notification deleted' });
    } catch (error) {
        console.error('Error deleting notification:', error);
        res.status(500).json({ success: false, message: error.message });
    }
});

module.exports = router;
