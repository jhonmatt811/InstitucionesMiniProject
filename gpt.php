<div id="departamento_container" style="display: none;">
    <label for="departamento" class="block text-black font-medium mb-1">Departamento</label>
    <select id="departamento" name="departamento" class="w-full p-2 border border-gray-300 rounded-md">
        <option value="">Todos</option>
        <?php foreach ($departamentosNoRepeat as $depto): ?>
            <option 
                value="<?php echo htmlspecialchars($depto["cod_depto"]); ?>" 
                <?= $departamentoSeleccionado == $depto["cod_depto"] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($depto["nomb_depto"]); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Selección de Sector -->
<div id="sector_container" style="display: none;">
    <label for="sector" class="block text-black font-medium mb-1">Tipo Sector</label>
    <select id="sector" name="sector" class="w-full p-2 border border-gray-300 rounded-md">
        <option value="sect_01" <?= $sectorSeleccionado == 'sect_01' ? 'selected' : ''; ?>>Pública</option>
        <option value="sect_02" <?= $sectorSeleccionado == 'sect_02' ? 'selected' : ''; ?>>Privada</option>
    </select>
</div>

<!-- Selección de Acto Administrativo -->
<div id="acto_container" style="display: none;">
    <label for="acto" class="block text-black font-medium mb-1">Tipo Acto Administrativo</label>
    <select id="acto" name="acto" class="w-full p-2 border border-gray-300 rounded-md">
        <?php foreach ($tiposActo as $item): ?>
            <option 
                value="<?php echo htmlspecialchars($item['cod_admon']); ?>" 
                <?= $actoSeleccionado == $item['cod_admon'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($item['nomb_admon']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
