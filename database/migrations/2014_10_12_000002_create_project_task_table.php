<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('id');
            $table->string('ticket_number',30)->unique();

            $table->string('title',300);
            $table->text('customer_report');
            $table->text('technical_report')->nullable();

            // Estimativa de Horas a serem trabalhadas
            $table->integer('expected_time_hours')->nullable();
            $table->integer('expected_time_minute')->nullable();

            // Horas Reais trabalhadas (Contagem inicia no momento que mudasse o status
            $table->integer('hour_worked_hours')->nullable();
            $table->integer('hour_worked_minute')->nullable();

            // Registra as data de Inicio e Finalização da Atividade
            $table->datetime('started_at')->nullable();
            $table->datetime('finish_at')->nullable();

            $table->bigInteger('reporter_id')->nullable(); // Usuário que reporta a ocorrência
            $table->bigInteger('project_id')->nullable(); // Projeto da ocorrência
            $table->bigInteger('enterprise_id')->nullable(); // Empresa que tem o Projeto e tem

            $table->bigInteger('technician_id')->nullable(); // Projeto da ocorrência
            $table->bigInteger('supervisor_id')->nullable(); // Projeto da ocorrência

            // Adotar uma escala de 0 a 10 (Normal, Urgente, Crítico, Emergência
            // 0 - Normal > Erros que não interferem no funcionamento do Software contudo precisa ser corrigido (Resposta: 24 Hora, Resolução: 24 Horas)
            // 1 - Urgente > Erros que interferem na lógica de negócio do cliente (Exceptions inrregulares) (Resposta: 12 Hora, Resolução: 24 Horas)
            // 2 - Emergência > Erros que interferem de forma parcial no funcionamento do sistema. (Resposta: 4 Hora, Resolução: 12 Horas)
            // 3 - Crítico > Erros que interferem totalmente no funcionamento do Sistema. (Resposta: 1 Hora, Resolução: 8 Horas)
            $table->integer('priority')->nullable()->default(0);

            $table->bigInteger('status_id')->nullable();
            $table->bigInteger('type_id')->nullable(); // Bug, Correção, Backup, Suporte etc

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->on('system_class')->references('id');
            $table->foreign('type_id')->on('system_class')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

/*
Fluxo do Status do Chamado
Aberto -> Em Analise
          Concluido
          Cancelado

Em Analise -> Em Execução
              Aguardando Recurso

Em Execução -> Aguardando Recurso
               Pendente no Cliente
               Concluido
               Cancelado

Pendente no Cliente -> Em Execução
                       Cancelado
                       Concluido
                       Aguardando Recurso

Aguardando Recurso -> Em Execução
                      Cancelado

Concluido -> X
Cancelado -> X


 */
