<?php

namespace Dena\IranPayment\LaravelAdmin\Http\Controllers;

use Illuminate\Routing\Controller;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

use Illuminate\Database\Eloquent\Model;

use Dena\IranPayment\IranPayment;
use Dena\IranPayment\Helpers\Currency;
use Dena\IranPayment\Models\IranPaymentTransaction;

class IranPaymentTransactionController extends Controller
{
    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header(__('iranpayment::laravel-admin.bank_transactions_list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(__('iranpayment::laravel-admin.bank_transaction_details'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param int $id
     * @param Content $content
     * @return Content
     */
    public function edit(int $id, Content $content)
    {
        return $content
            ->header(__('iranpayment::laravel-admin.bank_transaction_edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new IranPaymentTransaction);

        $grid->disableExport();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->disableColumnSelector(false);
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });
        $grid->actions(function ($actions) {
            $actions->disableDelete();
        });
        $grid->filter(function(Grid\Filter $filter) {
            $filter->disableIdFilter();

            $filter->equal('id', __('iranpayment::laravel-admin.columns.id'));

            $filter->like('code', __('iranpayment::laravel-admin.columns.code'));
            $filter->like('tracking_code', __('iranpayment::laravel-admin.columns.tracking_code'));

            $filter->equal('gateway', __('iranpayment::laravel-admin.columns.gateway'))->multipleSelect([
                IranPayment::SAMAN => IranPayment::SAMAN,
                IranPayment::SADAD => IranPayment::SADAD,
                IranPayment::PAYDOTIR => IranPayment::PAYDOTIR,
                IranPayment::ZARINPAL => IranPayment::ZARINPAL,
                IranPayment::PAYPING => IranPayment::PAYPING,
                IranPayment::NOVINOPAY => IranPayment::NOVINOPAY,
                IranPayment::TEST => IranPayment::TEST,
            ]);

            $filter->equal('status', __('iranpayment::laravel-admin.columns.status'))->multipleSelect([
                IranPaymentTransaction::T_INIT => __('iranpayment::laravel-admin.statuses.init'),
                IranPaymentTransaction::T_SUCCEED => __('iranpayment::laravel-admin.statuses.succeed'),
                IranPaymentTransaction::T_FAILED => __('iranpayment::laravel-admin.statuses.failed'),
                IranPaymentTransaction::T_PENDING => __('iranpayment::laravel-admin.statuses.pending'),
                IranPaymentTransaction::T_VERIFY_PENDING => __('iranpayment::laravel-admin.statuses.verify_pending'),
                IranPaymentTransaction::T_PAID_BACK => __('iranpayment::laravel-admin.statuses.paid_back'),
                IranPaymentTransaction::T_CANCELED => __('iranpayment::laravel-admin.statuses.canceled'),
            ]);

            $filter->equal('amount', __('iranpayment::laravel-admin.columns.amount'));

            $filter->equal('currency', __('iranpayment::laravel-admin.columns.currency'))->select([
                Currency::IRR => Currency::IRR,
                Currency::IRT => Currency::IRT,
            ]);

            $options = [
                'format' => 'YYYY-MM-DD HH:mm:ss',
                'locale' => 'en',
            ];
            $filter->between('paid_at', __('iranpayment::laravel-admin.columns.paid_at'))->datetime($options);
            $filter->between('created_at', __('iranpayment::laravel-admin.columns.created_at'))->datetime($options);
            $filter->between('updated_at', __('iranpayment::laravel-admin.columns.updated_at'))->datetime($options);
        });

        $grid->column('id', __('iranpayment::laravel-admin.columns.id'))->sortable();
        $grid->column('code', __('iranpayment::laravel-admin.columns.code'));
        $grid->column('tracking_code', __('iranpayment::laravel-admin.columns.tracking_code'));
        $grid->column('reference_number', __('iranpayment::laravel-admin.columns.reference_number'))->hide();
        $grid->column('gateway', __('iranpayment::laravel-admin.columns.gateway'));
        $grid->column('status', __('iranpayment::laravel-admin.columns.status'))
            ->replace([
                IranPaymentTransaction::T_INIT => __('iranpayment::laravel-admin.statuses.init'),
                IranPaymentTransaction::T_SUCCEED => __('iranpayment::laravel-admin.statuses.succeed'),
                IranPaymentTransaction::T_FAILED => __('iranpayment::laravel-admin.statuses.failed'),
                IranPaymentTransaction::T_PENDING => __('iranpayment::laravel-admin.statuses.pending'),
                IranPaymentTransaction::T_VERIFY_PENDING => __('iranpayment::laravel-admin.statuses.verify_pending'),
                IranPaymentTransaction::T_PAID_BACK => __('iranpayment::laravel-admin.statuses.paid_back'),
                IranPaymentTransaction::T_CANCELED => __('iranpayment::laravel-admin.statuses.canceled'),
            ])
            ->label([
                IranPaymentTransaction::T_INIT => 'info',
                IranPaymentTransaction::T_SUCCEED => 'success',
                IranPaymentTransaction::T_FAILED => 'danger',
                IranPaymentTransaction::T_PENDING => 'info',
                IranPaymentTransaction::T_VERIFY_PENDING => 'info',
                IranPaymentTransaction::T_PAID_BACK => 'warning',
                IranPaymentTransaction::T_CANCELED => 'default',
            ]);
        $grid->column('amount', __('iranpayment::laravel-admin.columns.amount'))->display(function ($value) {
            return number_format($value, 0);
        });
        $grid->column('currency', __('iranpayment::laravel-admin.columns.currency'))->hide()->label('default');
        $grid->column('paid_at', __('iranpayment::laravel-admin.columns.paid_at'));
        $grid->column('created_at', __('iranpayment::laravel-admin.columns.created_at'))->hide()->sortable();
        $grid->column('updated_at', __('iranpayment::laravel-admin.columns.updated_at'))->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param int $id
     * @return Show
     */
    protected function detail(int $id)
    {
        $show = new Show(IranPaymentTransaction::findOrFail($id));

        $show
            ->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });

        $show->id(__('iranpayment::laravel-admin.columns.id'));
        $show->code(__('iranpayment::laravel-admin.columns.code'));
        $show->divider();
        $show->payable_id(__('iranpayment::laravel-admin.columns.payable_id'));
        $show->payable_type(__('iranpayment::laravel-admin.columns.payable_type'));
        $show->divider();
        $show->gateway(__('iranpayment::laravel-admin.columns.gateway'));
        $show->amount(__('iranpayment::laravel-admin.columns.amount'));
        $show->currency(__('iranpayment::laravel-admin.columns.currency'));
        $show->status(__('iranpayment::laravel-admin.columns.status'))->using([
            IranPaymentTransaction::T_INIT => __('iranpayment::laravel-admin.statuses.init'),
            IranPaymentTransaction::T_SUCCEED => __('iranpayment::laravel-admin.statuses.succeed'),
            IranPaymentTransaction::T_FAILED => __('iranpayment::laravel-admin.statuses.failed'),
            IranPaymentTransaction::T_PENDING => __('iranpayment::laravel-admin.statuses.pending'),
            IranPaymentTransaction::T_VERIFY_PENDING => __('iranpayment::laravel-admin.statuses.verify_pending'),
            IranPaymentTransaction::T_PAID_BACK => __('iranpayment::laravel-admin.statuses.paid_back'),
            IranPaymentTransaction::T_CANCELED => __('iranpayment::laravel-admin.statuses.canceled'),
        ]);
        $show->divider();
        $show->tracking_code(__('iranpayment::laravel-admin.columns.tracking_code'));
        $show->reference_number(__('iranpayment::laravel-admin.columns.reference_number'));
        $show->divider();
        $show->card_number(__('iranpayment::laravel-admin.columns.card_number'));
        $show->full_name(__('iranpayment::laravel-admin.columns.full_name'));
        $show->email(__('iranpayment::laravel-admin.columns.email'));
        $show->mobile(__('iranpayment::laravel-admin.columns.mobile'));
        $show->description(__('iranpayment::laravel-admin.columns.description'));
        $show->divider();
        $show->errors(__('iranpayment::laravel-admin.columns.errors'));
        $show->extra(__('iranpayment::laravel-admin.columns.extra'));
        $show->gateway_data(__('iranpayment::laravel-admin.columns.gateway_data'));
        $show->divider();
        $show->paid_at(__('iranpayment::laravel-admin.columns.paid_at'));
        $show->created_at(__('iranpayment::laravel-admin.columns.created_at'));
        $show->updated_at(__('iranpayment::laravel-admin.columns.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new IranPaymentTransaction);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        $form->display('id', __('iranpayment::laravel-admin.columns.id'));
        $form->display('code', __('iranpayment::laravel-admin.columns.code'));
        $form->divider();
        $form->display('payable_id', __('iranpayment::laravel-admin.columns.payable_id'));
        $form->display('payable_type', __('iranpayment::laravel-admin.columns.payable_type'));
        $form->divider();
        $form->display('gateway', __('iranpayment::laravel-admin.columns.gateway'));
        $form->display('amount', __('iranpayment::laravel-admin.columns.amount'));
        $form->display('currency', __('iranpayment::laravel-admin.columns.currency'));
        $form->select('status', __('iranpayment::laravel-admin.columns.status'))->options([
            IranPaymentTransaction::T_INIT => __('iranpayment::laravel-admin.statuses.init'),
            IranPaymentTransaction::T_SUCCEED => __('iranpayment::laravel-admin.statuses.succeed'),
            IranPaymentTransaction::T_FAILED => __('iranpayment::laravel-admin.statuses.failed'),
            IranPaymentTransaction::T_PENDING => __('iranpayment::laravel-admin.statuses.pending'),
            IranPaymentTransaction::T_VERIFY_PENDING => __('iranpayment::laravel-admin.statuses.verify_pending'),
            IranPaymentTransaction::T_PAID_BACK => __('iranpayment::laravel-admin.statuses.paid_back'),
            IranPaymentTransaction::T_CANCELED => __('iranpayment::laravel-admin.statuses.canceled'),
        ]);
        $form->divider();
        $form->display('tracking_code', __('iranpayment::laravel-admin.columns.tracking_code'));
        $form->display('reference_number', __('iranpayment::laravel-admin.columns.reference_number'));
        $form->divider();
        $form->display('card_number', __('iranpayment::laravel-admin.columns.card_number'));
        $form->display('full_name', __('iranpayment::laravel-admin.columns.full_name'));
        $form->display('email', __('iranpayment::laravel-admin.columns.email'));
        $form->display('mobile', __('iranpayment::laravel-admin.columns.mobile'));
        $form->display('description', __('iranpayment::laravel-admin.columns.description'));
        $form->divider();
        $form->display('errors', __('iranpayment::laravel-admin.columns.errors'));
        $form->display('extra', __('iranpayment::laravel-admin.columns.extra'));
        $form->display('gateway_data', __('iranpayment::laravel-admin.columns.gateway_data'));
        $form->divider();
        $form->display('paid_at', __('iranpayment::laravel-admin.columns.paid_at'));
        $form->display('created_at', __('iranpayment::laravel-admin.columns.created_at'));
        $form->display('updated_at', __('iranpayment::laravel-admin.columns.updated_at'));

        return $form;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param mixed $resource
     *
     * @return \Illuminate\Http\Response
     */
    public function update($resource)
    {
        if ($resource instanceof Model) {
            return $this->form()->update($resource->id);
        }

        return $this->form()->update($resource);
    }
}
