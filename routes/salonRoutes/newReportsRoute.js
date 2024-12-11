const express = require('express')
const router = express.Router()
const {
  subscriptionPlan,
  category,
  serviceType,
  service,
  socialLink,
  jobs,
} = require('../../models')
const Controller = require('../../controllers/salonControllers/newReportsController')
const factory = require('../../controllers/handlerFactory')
const validateToken = require('../../middlewares/accessCheck')
const multer = require('multer')
const catchAsync = require('../../middlewares/catchAync')
const path = require('path')

// !Module:1 Auth
router.use(validateToken)
console.log('🚀 ~ IN NEW ROUTE FILe:')

router.get(
  '/busiest-vs-quietest/:basedOn',
  catchAsync(Controller.busiestVsQuietest),
)
router.get('/financial-report', catchAsync(Controller.financialReport))
module.exports = router
